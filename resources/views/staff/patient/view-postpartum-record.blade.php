@extends('layouts.staff.layout')

@section('title', 'View Postpartum Record')
@section('page-title', 'View Postpartum Record')

@section('content')
<div class="container-fluid main-content">

    <div class="form-card">

        <div class="form-header">
            <h5 >
                <i class="fas fa-baby me-2"></i>
               Postpartum Record
            </h5>
             <div class="header-actions">
            <a href="{{ route('patient.pdfRecords', $client->id) }}" class="back-button">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
             </div>
        </div>

        <div class="p-4">

            {{-- PATIENT DETAILS --}}
            <div class="section-title">Mother's Information</div>
            <div class="info-table">
                <table>
                    <tr>
                        <th>Name</th>
                        <td>{{ $client->first_name }} {{ $client->last_name }}</td>
                        <th>Age</th>
                        <td>{{ $patient->age }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $client->client_phone }}</td>
                        <th>Address</th>
                        <td>
                            {{ $address->village }}, 
                            {{ $address->city_municipality }},
                            {{ $address->province }}
                        </td>
                    </tr>
                </table>
            </div>

            {{-- POSTPARTUM VITALS --}}
            <div class="section-title mt-4">Mother's Postpartum Vitals</div>
            <div class="info-table">
                <table>
                    <tr>
                        <th>Blood Pressure</th>
                        <td>{{ $postpartum->postpartum_bp }}</td>
                        <th>Temperature</th>
                        <td>{{ $postpartum->postpartum_temp }}</td>
                    </tr>
                    <tr>
                        <th>Respiratory Rate</th>
                        <td>{{ $postpartum->postpartum_rr }}</td>
                        <th>Pulse Rate</th>
                        <td>{{ $postpartum->postpartum_pr }}</td>
                    </tr>
                </table>
            </div>

            {{-- NEWBORN DETAILS --}}
            <div class="section-title mt-4">Newborn Measurements</div>
            <div class="info-table">
                <table>
                    <tr>
                        <th>Weight</th>
                        <td>{{ $postpartum->newborn_weight }}</td>
                        <th>Head Circumference</th>
                        <td>{{ $postpartum->newborn_hc }}</td>
                    </tr>
                    <tr>
                        <th>Chest Circumference</th>
                        <td>{{ $postpartum->newborn_cc }}</td>
                        <th>Abdominal Circumference</th>
                        <td>{{ $postpartum->newborn_ac }}</td>
                    </tr>
                    <tr>
                        <th>Length</th>
                        <td>{{ $postpartum->newborn_length }}</td>
                        <td></td><td></td>
                    </tr>
                </table>
            </div>

            {{-- REMARKS --}}
            <div class="section-title mt-4">Remarks</div>
            <div class="remarks-box">
                {{ $postpartum->remarks->notes ?? 'No remarks provided.' }}
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
