@extends('layouts.staff.layout')

@section('title', 'View Baby Registration')
@section('page-title', 'View Baby Registration')

@section('content')
<div class="container-fluid main-content">

    <div class="form-card">
        <div class="form-header">
            <h5>
                <i class="fas fa-baby me-2"></i> 
                Baby Registration Record
            </h5>
            <div class="header-actions">
            <a href="{{ route('patient.pdfRecords', $client->id ?? 0) }} "
                class="back-button">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
            </div>
        </div>

        <div class="p-4">

            {{-- Baby Information --}}
            <div class="section-title mt-3">Baby Information</div>
            <div class="info-table">
                <table>
                    <tr>
                        <th>Full Name</th>
                        <td>{{ $babyRegistration->baby_first_name ?? '' }} {{ $babyRegistration->baby_middle_name ?? '' }} {{ $babyRegistration->baby_last_name ?? '' }}</td>

                        <th>Sex</th>
                        <td>{{ $babyRegistration->sex ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td>{{ $babyRegistration->date_of_birth ? \Carbon\Carbon::parse($babyRegistration->date_of_birth)->format('M d, Y') : 'N/A' }}</td>

                        <th>Time of Birth</th>
                        <td>{{ $babyRegistration->time_of_birth ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Place of Birth</th>
                        <td>{{ $babyRegistration->place_of_birth ?? 'N/A' }}</td>

                        <th>Type of Birth</th>
                        <td>{{ $babyRegistration->type_of_birth ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Birth Order</th>
                        <td>{{ $babyRegistration->birth_order ?? 'N/A' }}</td>

                        <th>Weight at Birth</th>
                        <td>{{ $babyRegistration->weight_at_birth ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>

            {{-- Mother Information --}}
            <div class="section-title mt-4">Mother Information</div>
            @if ($mother)
            <div class="info-table">
                <table>
                    <tr>
                        <th>Full Name</th>
                        <td>{{ $mother->patient->client->first_name ?? '' }}
                            {{ $mother->maiden_middle_name ?? '' }}
                            {{ $mother->patient->client->last_name ?? '' }}
                        </td>
                        <th>Age</th>
                        <td>{{ $mother->patient->age ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                      <td>{{ $mother->patient->client->full_address ?? 'N/A' }}</td>

                        <th>Citizenship</th>
                        <td>{{ $mother->citizenship ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Religion</th>
                        <td>{{ $mother->religion ?? 'N/A' }}</td>
                        <th>Occupation</th>
                        <td>{{ $mother->occupation ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Total Children Alive</th>
                        <td>{{ $mother->total_children_alive ?? 'N/A' }}</td>
                        <th>Children Still Living</th>
                        <td>{{ $mother->children_still_living ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Children Deceased</th>
                        <td>{{ $mother->children_deceased ?? 'N/A' }}</td>
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            @else
            <p class="text-danger">Mother information not available.</p>
            @endif

            {{-- Father Information --}}
            <div class="section-title mt-4">Father Information</div>
            @if ($father)
            <div class="info-table">
                <table>
                    <tr>
                        <th>Full Name</th>
                        <td>{{ $father->patient->spouse_fname ?? '' }} {{ $father->middle_name ?? '' }} {{ $father->patient->spouse_lname ?? '' }}</td>
                        <th>Age</th>
                        <td>{{ $father->age ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $father->address ?? 'N/A' }}</td>
                        <th>Citizenship</th>
                        <td>{{ $father->citizenship ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Religion</th>
                        <td>{{ $father->religion ?? 'N/A' }}</td>
                        <th>Occupation</th>
                        <td>{{ $father->occupation ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            @else
            <p class="text-danger">Father information not available.</p>
            @endif

            {{-- Additional Information --}}
            <div class="section-title mt-4">Additional Information</div>
            @if ($additional)
            <div class="info-table">
                <table>
                    <tr>
                        <th>Marriage Date</th>
                        <td>{{ $additional->marriage_date ? \Carbon\Carbon::parse($additional->marriage_date)->format('M d, Y') : 'N/A' }}</td>
                        <th>Marriage Place</th>
                        <td>{{ $additional->marriage_place ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Birth Attendant</th>
                        <td>{{ $additional->birth_attendant ?? 'N/A' }}</td>
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
            @else
            <p class="text-danger">Additional information not available.</p>
            @endif

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
    </style>

</div>
@endsection
