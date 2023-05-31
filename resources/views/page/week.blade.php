@extends('layouts.layout')
@section('title', 'Weekly Report')
@section('content')

    <br><br><br>
    <div class="container">
        <h1>Weekly Report</h1>
        <form method="GET" action="{{ route('week') }}">
            <div class="d-flex">
                <select name="month">
                    @foreach ($months as $m)
                        <option value="{{ $m->id }}" {{ $m->id == $selectedMonth ? 'selected' : '' }}>
                            {{ $m->month }}
                        </option>
                    @endforeach
                </select>
    
                <select name="week_number">
                    @foreach ($week_number as $w)
                        <option value="{{ $w->number }}" {{ $w->number == $selectedWeekNumber ? 'selected' : '' }}>
                            Week {{ $w->id }}
                        </option>
                    @endforeach
                </select>
    
                <select name="year">
                    @foreach ($years as $y)
                        <option value="{{ $y->year }}" {{ $y->year == $selectedYear ? 'selected' : '' }}>
                            {{ $y->year }}
                        </option>
                    @endforeach
                </select>
    
                <button type="submit">Get Date</button>
            </div>
        </form>
        @include('component.week.weekSummary')
        @yield('table')
        {{-- @include('component.week.weekTable') --}}
    </div>
   

@endsection
