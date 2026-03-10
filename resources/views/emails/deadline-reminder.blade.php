<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case Deadline Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            border-radius: 8px 8px 0 0;
            margin: -30px -30px 30px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .date {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .overdue {
            background-color: #ffebee;
            color: #c62828;
        }
        .today {
            background-color: #fff3e0;
            color: #e65100;
        }
        .warning {
            background-color: #fff9c4;
            color: #f57f17;
        }
        .info {
            background-color: #e3f2fd;
            color: #1565c0;
        }
        .case-item {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #ccc;
            border-radius: 4px;
        }
        .case-item.overdue {
            border-left-color: #c62828;
        }
        .case-item.today {
            border-left-color: #e65100;
        }
        .case-item.warning {
            border-left-color: #f57f17;
        }
        .case-item.info {
            border-left-color: #1565c0;
        }
        .case-number {
            font-weight: bold;
            font-size: 16px;
            color: #2c3e50;
        }
        .case-title {
            color: #555;
            margin: 5px 0;
        }
        .case-detail {
            font-size: 14px;
            color: #777;
        }
        .deadline {
            font-weight: bold;
        }
        .no-cases {
            text-align: center;
            color: #999;
            padding: 20px;
            font-style: italic;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        .icon {
            font-size: 20px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚖️ Case Deadline Reminder</h1>
        </div>

        <div class="date">
            📅 {{ $reminderData['date'] }}
        </div>

        @if(count($reminderData['overdueCases']) > 0)
        <div class="section">
            <div class="section-title overdue">
                <span class="icon">🔴</span> OVERDUE CASES ({{ count($reminderData['overdueCases']) }})
            </div>
            @foreach($reminderData['overdueCases'] as $case)
            <div class="case-item overdue">
                <div class="case-number">{{ $case->case_number }}</div>
                <div class="case-title">{{ $case->case_title }}</div>
                <div class="case-detail">
                    <strong>Client:</strong> {{ $case->client_name }}<br>
                    <strong class="deadline">Deadline:</strong> {{ $case->deadline_date->format('F d, Y') }}<br>
                    <strong style="color: #c62828;">{{ abs($case->remaining_days) }} day(s) overdue</strong>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(count($reminderData['deadlinesToday']) > 0)
        <div class="section">
            <div class="section-title today">
                <span class="icon">⏰</span> DEADLINES TODAY ({{ count($reminderData['deadlinesToday']) }})
            </div>
            @foreach($reminderData['deadlinesToday'] as $case)
            <div class="case-item today">
                <div class="case-number">{{ $case->case_number }}</div>
                <div class="case-title">{{ $case->case_title }}</div>
                <div class="case-detail">
                    <strong>Client:</strong> {{ $case->client_name }}<br>
                    <strong class="deadline">Deadline:</strong> {{ $case->deadline_date->format('F d, Y') }} (TODAY)
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(count($reminderData['deadlinesIn3Days']) > 0)
        <div class="section">
            <div class="section-title warning">
                <span class="icon">⚠️</span> DEADLINES IN 3 DAYS ({{ count($reminderData['deadlinesIn3Days']) }})
            </div>
            @foreach($reminderData['deadlinesIn3Days'] as $case)
            <div class="case-item warning">
                <div class="case-number">{{ $case->case_number }}</div>
                <div class="case-title">{{ $case->case_title }}</div>
                <div class="case-detail">
                    <strong>Client:</strong> {{ $case->client_name }}<br>
                    <strong class="deadline">Deadline:</strong> {{ $case->deadline_date->format('F d, Y') }}
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(count($reminderData['deadlinesIn7Days']) > 0)
        <div class="section">
            <div class="section-title info">
                <span class="icon">📌</span> DEADLINES IN 7 DAYS ({{ count($reminderData['deadlinesIn7Days']) }})
            </div>
            @foreach($reminderData['deadlinesIn7Days'] as $case)
            <div class="case-item info">
                <div class="case-number">{{ $case->case_number }}</div>
                <div class="case-title">{{ $case->case_title }}</div>
                <div class="case-detail">
                    <strong>Client:</strong> {{ $case->client_name }}<br>
                    <strong class="deadline">Deadline:</strong> {{ $case->deadline_date->format('F d, Y') }}
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(count($reminderData['hearingsToday']) > 0)
        <div class="section">
            <div class="section-title info">
                <span class="icon">📅</span> HEARINGS TODAY ({{ count($reminderData['hearingsToday']) }})
            </div>
            @foreach($reminderData['hearingsToday'] as $case)
            <div class="case-item info">
                <div class="case-number">{{ $case->case_number }}</div>
                <div class="case-title">{{ $case->case_title }}</div>
                <div class="case-detail">
                    <strong>Client:</strong> {{ $case->client_name }}<br>
                    <strong class="deadline">Hearing:</strong> {{ $case->hearing_date->format('F d, Y') }} (TODAY)
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="footer">
            <p>This is an automated reminder from the Case Matrix System.</p>
            <p>Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
