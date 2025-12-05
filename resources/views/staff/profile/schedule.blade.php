@extends('layouts.staff.layout')

@section('title', 'Schedule - Letty\'s Birthing Home')
@section('page-title', 'My Schedule')

@section('content')

    @php
        $workDaysCollection = $staff->workDays->pluck('day');
        $workDaysReadable = $workDaysCollection->map(fn ($day) => ucfirst($day))->implode(', ');
        $workDayCount = $workDaysCollection->count();
        $shiftRaw = optional($staff->staff_work_days)->shift ?? 'day';
        $shiftLabel = ucfirst($shiftRaw);
        $shiftHours = strtolower($shiftRaw) === 'night' ? '8:00 PM — 4:00 AM' : '8:00 AM — 4:00 PM';
        $weekStart = \Carbon\Carbon::now()->startOfWeek();
        $weekEnd = \Carbon\Carbon::now()->endOfWeek();
    @endphp

    <div class="container-fluid main-content schedule-page">
        <section class="schedule-headline">
            <div>
                <p class="eyebrow">Shift overview</p>
                <h2>Stay on top of your upcoming duties</h2>
                <p>Review your assigned shift pattern, see working days at a glance, and use the calendar to plan ahead.</p>
            </div>
            <div class="week-range">
                <span>This week</span>
                <strong>{{ $weekStart->format('M d') }} – {{ $weekEnd->format('M d, Y') }}</strong>
            </div>
        </section>

        <div class="schedule-layout">
            <section class="schedule-overview">
                <div class="info-card primary">
                    <div>
                        <p class="label">Shift type</p>
                        <p class="value">{{ $shiftLabel }} Shift</p>
                        <span class="subtext">{{ $shiftHours }}</span>
                    </div>
                    <div>
                        <p class="label">Assigned days</p>
                        <p class="value">{{ $workDayCount > 0 ? $workDayCount : '—' }}</p>
                        <span class="subtext">{{ $workDayCount > 0 ? $workDaysReadable : 'Awaiting assignment' }}</span>
                    </div>
                </div>

                <div class="info-card">
                    <div class="card-heading">
                        <p class="label">Weekly focus</p>
                        <span class="status-chip">In progress</span>
                    </div>
                    <ul class="focus-list">
                        <li><i class="fas fa-check-circle"></i> Sync with your handoff partner before every shift.</li>
                        <li><i class="fas fa-check-circle"></i> Review pending appointments from the dashboard.</li>
                        <li><i class="fas fa-check-circle"></i> Update post-shift notes within 24 hours.</li>
                    </ul>
                </div>

                <div class="info-card">
                    <div class="card-heading">
                        <p class="label">Working days</p>
                        <button class="link-button" onclick="goToToday()">Jump to today</button>
                    </div>
                    <div class="workday-chips">
                        @forelse ($workDaysCollection as $day)
                            <span class="chip">{{ ucfirst($day) }}</span>
                        @empty
                            <span class="chip chip-empty">No working days assigned yet</span>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="schedule-calendar">
                <div class="calendar-section">
                    <div class="calendar-header">
                        <div class="calendar-title">
                            <i class="fas fa-calendar-alt"></i>
                            <div>
                                <span class="eyebrow">Monthly Shift Calendar</span>
                                <p class="month-title" id="monthTitle">August 2025</p>
                            </div>
                        </div>
                    </div>

                    <div class="calendar-grid" id="calendarGrid"></div>

                    <div class="calendar-footer">
                        <div class="calendar-legend">
                            <span><span class="legend-dot day"></span>Day shift</span>
                            <span><span class="legend-dot night"></span>Night shift</span>
                            <span><span class="legend-dot off"></span>Day off</span>
                        </div>
                        <p class="calendar-note">
                            <i class="fas fa-lightbulb"></i>
                            Select a highlighted day to review the exact shift window shown in the panel above.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{-- Page-specific styles --}}
    <style>
        .schedule-page {
            display: flex;
            flex-direction: column;
            gap: 24px;
            padding-bottom: 2rem;
        }

        .schedule-headline {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            padding: 24px;
            border-radius: var(--border-radius);
            background: linear-gradient(125deg, rgba(78, 157, 118, 0.15), rgba(13, 47, 77, 0.08));
            border: 1px solid rgba(78, 157, 118, 0.2);
        }

        .schedule-headline h2 {
            font-size: 1.85rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--primary-dark);
        }

        .schedule-headline p {
            margin: 0;
            color: #4b5563;
        }

        .week-range {
            text-align: right;
            min-width: 180px;
        }

        .week-range span {
            display: block;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            color: var(--primary-color);
        }

        .week-range strong {
            font-size: 1.1rem;
            color: var(--primary-dark);
        }

        .eyebrow {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            margin-bottom: 4px;
            color: var(--primary-color);
        }

        .schedule-layout {
            display: grid;
            grid-template-columns: minmax(280px, 1fr) 2fr;
            gap: 24px;
        }

        .schedule-overview {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .info-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--card-shadow);
        }

        .info-card.primary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
        }

        .label {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .value {
            font-size: 1.35rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin: 0;
        }

        .subtext {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .card-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .status-chip {
            background: rgba(78, 157, 118, 0.1);
            color: var(--primary-color);
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .focus-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
            color: #374151;
        }

        .focus-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
        }

        .focus-list i {
            color: var(--primary-color);
        }

        .link-button {
            border: none;
            background: none;
            color: var(--primary-color);
            font-weight: 600;
            cursor: pointer;
            padding: 0;
        }

        .workday-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .chip {
            background: #f1f5f9;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 0.85rem;
            color: #0f172a;
        }

        .chip-empty {
            background: #fff7ed;
            color: #c2410c;
            border: 1px solid #fdba74;
        }

        .schedule-calendar .calendar-section {
            height: 100%;
        }

        .schedule-calendar .calendar-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .schedule-calendar .calendar-title i {
            font-size: 1.25rem;
            color: var(--primary-color);
        }

        .schedule-calendar .month-title {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .schedule-page .calendar-header-cell {
            background: #142136;
            color: #fff;
        }

        .calendar-footer {
            margin-top: 18px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            border-top: 1px solid #e2e8f0;
            padding-top: 16px;
        }

        .calendar-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            font-size: 0.9rem;
            color: #475569;
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .legend-dot.day {
            background: #34d399;
        }

        .legend-dot.night {
            background: #60a5fa;
        }

        .legend-dot.off {
            background: #cbd5f5;
        }

        .calendar-note {
            margin: 0;
            font-size: 0.9rem;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .calendar-note i {
            color: #fbbf24;
        }

        @media (max-width: 992px) {
            .schedule-layout {
                grid-template-columns: 1fr;
            }

            .schedule-headline {
                flex-direction: column;
                text-align: center;
            }

            .week-range {
                text-align: center;
            }
        }

    </style>

    {{-- Pass PHP data safely to JS --}}
    <script>
        window.staffData = {
            workDays: @json($staff->workDays->pluck('day')->toArray()),
            shiftType: '{{ $staff->staff_work_days->shift ?? 'day' }}'
        };
    </script>

    <script src="{{ asset('script/staff/schedule.js') }}"></script>
@endsection
