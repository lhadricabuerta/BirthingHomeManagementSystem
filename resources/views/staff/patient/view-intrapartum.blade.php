@extends('layouts.staff.layout')

@section('title', 'View Intrapartum Record')
@section('page-title', 'View Intrapartum Record')

@section('content')
<div class="container-fluid main-content">

    <div class="form-card">
        <div class="form-header">
            <h5 >
                <i class="fas fa-file-medical-alt me-2"></i> 
                Intrapartum Record
            </h5>
              <div class="header-actions">
            <a href="{{ route('patient.pdfRecords', $record->intrapartumRecord->delivery->patient->client->id) }}"
               class="back-button">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
              </div>
        </div>

        <div class="p-4">

            {{-- Patient Basic Info --}}
            <div class="section-title mt-3">Patient Information</div>
            <div class="info-table">
                <table>
                    <tr>
                        <th>Patient Name</th>
                        <td>
                            {{ $record->intrapartumRecord->delivery->patient->client->first_name }}
                            {{ $record->intrapartumRecord->delivery->patient->client->last_name }}
                        </td>

                        <th>Age</th>
                        <td>{{ $record->intrapartumRecord->delivery->patient->age }}</td>
                    </tr>
                </table>
            </div>

            {{-- Intrapartum Vitals --}}
            <div class="section-title mt-4">Maternal Vitals</div>
            <div class="info-table">
                <table>
                    <tr>
                        <th>Blood Pressure</th>
                        <td>{{ $record->intrapartumRecord->bp }}</td>

                        <th>Temperature</th>
                        <td>{{ $record->intrapartumRecord->temp }}</td>
                    </tr>
                    <tr>
                        <th>Respiratory Rate</th>
                        <td>{{ $record->intrapartumRecord->rr }}</td>

                        <th>Pulse Rate</th>
                        <td>{{ $record->intrapartumRecord->pr }}</td>
                    </tr>
                </table>
            </div>

            {{-- Labour Assessment --}}
            <div class="section-title mt-4">Labor Assessment</div>
            <div class="info-table">
                <table>
                    <tr>
                        <th>Fundic Height</th>
                        <td>{{ $record->intrapartumRecord->fundic_height }}</td>

                        <th>Fetal Heart Tone</th>
                        <td>{{ $record->intrapartumRecord->fetal_heart_tone }}</td>
                    </tr>

                    <tr>
                        <th>Internal Exam</th>
                        <td>{{ $record->intrapartumRecord->internal_exam }}</td>

                        <th>Bag of Water</th>
                        <td>{{ $record->intrapartumRecord->bag_of_water }}</td>
                    </tr>
                </table>
            </div>

            {{-- Delivery Information --}}
            <div class="section-title mt-4">Delivery Information</div>
            <div class="info-table">
                <table>
                    <tr>
                        <th>Baby Delivered</th>
                        <td>{{ $record->intrapartumRecord->baby_delivered }}</td>

                        <th>Placenta Delivered</th>
                        <td>{{ $record->intrapartumRecord->placenta_delivered }}</td>
                    </tr>

                    <tr>
                        <th>Baby Sex</th>
                        <td>{{ $record->intrapartumRecord->baby_sex }}</td>
                        <td></td><td></td>
                    </tr>
                </table>
            </div>

            {{-- Remarks --}}
            <div class="section-title mt-4">Remarks</div>
            <div class="remarks-box">
                {{ $record->intrapartumRecord->remarks->notes ?? 'No remarks provided.' }}
            </div>

        </div>
    </div>

    <style>
        .section-title {
            font-weight: 600;
            font-size: 17px;
            margin-bottom: 8px;
        }

        .info-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table th {
            background: #f5f5f5;
            width: 20%;
            padding: 10px;
            font-weight: 600;
            border: 1px solid #ddd;
        }

        .info-table td {
            padding: 10px;
            border: 1px solid #ddd;
            background: #fff;
            width: 30%;
        }

        .remarks-box {
            border: 1px solid #ddd;
            background: #fff;
            padding: 12px;
            min-height: 80px;
            border-radius: 5px;
            line-height: 1.5;
        }
    </style>

</div>
@endsection
