<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PatientPdfRecord;
use App\Models\PatientImmunization;
use Barryvdh\DomPDF\Facade\Pdf;

class RegeneratePdf extends Command
{
    protected $signature = 'pdf:regenerate {recordId?}';
    protected $description = 'Regenerate patient PDF records';

    public function handle()
    {
        $recordId = $this->argument('recordId');
        
        if ($recordId) {
            // Regenerate single record
            $this->regenerateSingle($recordId);
            $this->info("PDF {$recordId} regenerated successfully!");
        } else {
            // Regenerate all records
            $this->info('Starting to regenerate all PDFs...');
            
            $total = PatientPdfRecord::count();
            $bar = $this->output->createProgressBar($total);
            $skipped = 0;
            $success = 0;
            
            PatientPdfRecord::chunk(10, function($records) use ($bar, &$skipped, &$success) {
                foreach ($records as $record) {
                    try {
                        $this->regenerateSingle($record->id);
                        $success++;
                    } catch (\Exception $e) {
                        $this->newLine();
                        $this->warn("Skipped PDF {$record->id}: {$e->getMessage()}");
                        $skipped++;
                    }
                    $bar->advance();
                }
            });
            
            $bar->finish();
            $this->newLine();
            $this->info("Completed! Success: {$success}, Skipped: {$skipped}");
        }
    }

    private function regenerateSingle($recordId)
    {
        $pdfRecord = PatientPdfRecord::with([
            'prenatalVisit.visitInfo',
            'patient.client.address'
        ])->findOrFail($recordId);

        // Check if prenatalVisit exists
        if (!$pdfRecord->prenatalVisit) {
            throw new \Exception("No prenatal visit found");
        }

        // Check if patient and client exist
        if (!$pdfRecord->patient || !$pdfRecord->patient->client) {
            throw new \Exception("No patient or client found");
        }

        $client = $pdfRecord->patient->client;
        $client->load('address', 'patient.maritalStatus');
        
        $prenatalVisit = $pdfRecord->prenatalVisit;
        $latestVisitInfo = $prenatalVisit->visitInfo()->latest('visit_date')->first();
        
        $immunizations = PatientImmunization::with('items.item')
            ->where('prenatal_visit_id', $prenatalVisit->id)
            ->get();

        $pdf = Pdf::loadView('staff.patient.pdf-record', [
            'patient' => $client,
            'latestPrenatal' => $prenatalVisit,
            'latestVisitInfo' => $latestVisitInfo,
            'immunizations' => $immunizations,
        ]);

        $pdfRecord->update([
            'file_data' => $pdf->output(),
        ]);
    }
}