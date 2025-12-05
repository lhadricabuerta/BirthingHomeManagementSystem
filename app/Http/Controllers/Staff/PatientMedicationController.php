<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\Patient;
use App\Models\PatientMedication;
use App\Models\PatientMedicationItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientMedicationController extends Controller
{

  public function history()
    {
        $medications = PatientMedication::with([
            'patient.client',
            'items.item.category',
        ])
        ->latest('prescribed_at') // 👈 Show most recent first
        ->get();

        return view('staff.patient.patient-medication-record', compact('medications'));
    }


    public function index()
    {
        $patients = Patient::with('client')->get();

        $medicines = $this->getPrioritizedItemsByCategory(2);
        $supplies  = $this->getPrioritizedItemsByCategory(3);

        return view('staff.patient.patient-medication', compact('patients', 'medicines', 'supplies'));
    }

    /**
     * Return one entry per item name, prioritizing the batch that expires first.
     */
    protected function getPrioritizedItemsByCategory(int $categoryId)
    {
        return InventoryItem::where('category_id', $categoryId)
            ->orderByRaw('CASE WHEN expiry_date IS NULL THEN 1 ELSE 0 END')
            ->orderBy('expiry_date')
            ->orderBy('batch_no')
            ->get()
            ->unique('item_name')
            ->values();
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'       => 'required|exists:patient,id',
            'items'            => 'required|array|min:1',
            'items.*.item_id'  => 'required|exists:inventory_items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Create parent medication record
                $medication = PatientMedication::create([
                    'patient_id'    => $request->patient_id,
                    'notes'         => $request->remarks,
                    'prescribed_at' => now(),
                ]);

                // Loop through each medication item
                foreach ($request->items as $item) {
                    $inventoryItem = InventoryItem::findOrFail($item['item_id']);

                    // Check stock
                    if ($inventoryItem->quantity < $item['quantity']) {
                        throw new \Exception("Not enough stock for {$inventoryItem->item_name}");
                    }

                    // Deduct stock
                    $inventoryItem->decrement('quantity', $item['quantity']);

                    // Save patient medication item
                    PatientMedicationItem::create([
                        'patient_medication_id' => $medication->id,
                        'item_id'               => $item['item_id'],
                        'quantity'              => $item['quantity'],
                    ]);
                }
            });

            // Success redirect to history page
            return redirect()->route('patientMedication.history')->with('swal', [
                'icon'  => 'success',
                'title' => 'Success!',
                'text'  => 'Medication recorded successfully.',
            ]);

        } catch (\Exception $e) {
            // Error alert (including stock issues)
            return redirect()->back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Error!',
                'text'  => $e->getMessage(),
            ]);
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        $medication = PatientMedication::with('items.item')->findOrFail($id);

        try {
            DB::transaction(function () use ($medication) {
                foreach ($medication->items as $item) {
                    if ($item->item) {
                        $item->item->increment('quantity', $item->quantity);
                    }
                    $item->delete();
                }

                $medication->delete();
            });

            return redirect()->route('patientMedication.history')->with('swal', [
                'icon'  => 'success',
                'title' => 'Deleted!',
                'text'  => 'Medication record was removed successfully.',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('patientMedication.history')->with('swal', [
                'icon'  => 'error',
                'title' => 'Deletion Failed',
                'text'  => $e->getMessage(),
            ]);
        }
    }

}
