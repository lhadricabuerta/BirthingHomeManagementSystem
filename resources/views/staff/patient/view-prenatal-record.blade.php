@extends('layouts.staff.layout')

@section('title', 'View Prenatal Record')
@section('page-title', 'View Prenatal Record')

@section('content')
<div class="container-fluid main-content">

    <div class="form-card">
        <div class="form-header">
            <h5 >
                <i class="fas fa-user me-2"></i>
                Prenatal Record
            </h5>
                <div class="header-actions">
            <a href="{{ route('patient.pdfRecords', $client->id) }}" class="back-button">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
                </div>
        </div>

        <div class="p-4">

            {{-- Patient Information --}}
            <div class="section-title mt-3">Patient Information</div>
            <div class="info-table">
                <table>
                    <tr>
                        <th>First Name</th>
                        <td>{{ $client->first_name }}</td>
                        <th>Last Name</th>
                        <td>{{ $client->last_name }}</td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td>{{ $client->patient->age }}</td>
                        <th>Marital Status</th>
                        <td>{{ $client->patient->maritalStatus->status ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $client->client_phone }}</td>
                        <th>Address</th>
                        <td>
                            {{ $address->village ?? '' }},
                            {{ $address->city_municipality ?? '' }},
                            {{ $address->province ?? '' }}
                        </td>
                    </tr>
                </table>
            </div>

            {{-- Prenatal Details --}}
            <div class="section-title mt-4">Prenatal Details</div>
            <div class="info-table">
                <table>
                    <tr>
                        <th>LMP</th>
                        <td>{{ $prenatalVisit->lmp ?? 'N/A' }}</td>
                        <th>EDC</th>
                        <td>{{ $prenatalVisit->edc ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>AOG</th>
                        <td>{{ $prenatalVisit->aog ?? 'N/A' }}</td>
                        <th>Gravida</th>
                        <td>{{ $prenatalVisit->gravida ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Para</th>
                        <td>{{ $prenatalVisit->para ?? 'N/A' }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>

            {{-- Maternal Vitals --}}
            <div class="section-title mt-4">Maternal Vitals</div>
            <div class="info-table">
                <table>
                    <tr>
                        <th>FHT</th>
                        <td>{{ $maternalVitals->fht ?? 'N/A' }}</td>
                        <th>FH</th>
                        <td>{{ $maternalVitals->fh ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Weight</th>
                        <td>{{ $maternalVitals->weight ?? 'N/A' }}</td>
                        <th>Blood Pressure</th>
                        <td>{{ $maternalVitals->blood_pressure ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Temperature</th>
                        <td>{{ $maternalVitals->temperature ?? 'N/A' }}</td>
                        <th>Respiratory Rate</th>
                        <td>{{ $maternalVitals->respiratory_rate ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Pulse Rate</th>
                        <td>{{ $maternalVitals->pulse_rate ?? 'N/A' }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>

            {{-- Remarks --}}
            <div class="section-title mt-4">Remarks</div>
            <div class="remarks-box">
                {{ $prenatalVisit->remarks->notes ?? 'No remarks provided.' }}
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
