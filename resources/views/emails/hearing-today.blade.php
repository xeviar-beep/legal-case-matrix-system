<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #6f42c1;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border: 2px solid #6f42c1;
            border-top: none;
        }
        .alert-box {
            background: #e7e3fc;
            border-left: 4px solid #6f42c1;
            padding: 15px;
            margin: 20px 0;
        }
        .case-details {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .detail-row {
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .detail-label {
            font-weight: bold;
            color: #99272D;
            display: inline-block;
            width: 150px;
        }
        .btn {
            display: inline-block;
            background: #99272D;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>👨‍⚖️ COURT HEARING TODAY</h1>
        </div>
        
        <div class="content">
            <div class="alert-box">
                <strong>📅 Hearing Scheduled Today</strong>
                <p>You have a court hearing scheduled for <strong>today</strong>. Please ensure you are prepared and arrive on time.</p>
            </div>

            <div class="case-details">
                <h2 style="color: #99272D; margin-top: 0;">Case Information</h2>
                
                <div class="detail-row">
                    <span class="detail-label">Case Number:</span>
                    <span>{{ $case->case_number }}</span>
                </div>
                
                @if($case->docket_no)
                <div class="detail-row">
                    <span class="detail-label">Docket No:</span>
                    <span>{{ $case->docket_no }}</span>
                </div>
                @endif
                
                <div class="detail-row">
                    <span class="detail-label">Case Title:</span>
                    <span>{{ $case->case_title }}</span>
                </div>
                
                @if($case->client_name)
                <div class="detail-row">
                    <span class="detail-label">Client:</span>
                    <span>{{ $case->client_name }}</span>
                </div>
                @endif
                
                <div class="detail-row">
                    <span class="detail-label">Case Type:</span>
                    <span>{{ ucfirst($case->case_type) }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Court/Agency:</span>
                    <span style="font-weight: bold;">{{ $case->court_agency }}</span>
                </div>
                
                @if($case->region)
                <div class="detail-row">
                    <span class="detail-label">Region:</span>
                    <span>{{ $case->region }}</span>
                </div>
                @endif
                
                <div class="detail-row">
                    <span class="detail-label">Hearing Date:</span>
                    <span style="color: #6f42c1; font-weight: bold;">
                        {{ $case->hearing_date ? \Carbon\Carbon::parse($case->hearing_date)->format('F d, Y (l)') : '-' }} - TODAY
                    </span>
                </div>
                
                @if($case->deadline_date)
                <div class="detail-row">
                    <span class="detail-label">Case Deadline:</span>
                    <span>{{ $case->deadline_date ? \Carbon\Carbon::parse($case->deadline_date)->format('F d, Y') : '-' }}</span>
                </div>
                @endif
                
                @if($case->notes)
                <div class="detail-row">
                    <span class="detail-label">Notes:</span>
                    <span>{{ $case->notes }}</span>
                </div>
                @endif
            </div>

            <center>
                <a href="{{ url('/cases/' . $case->id) }}" class="btn">
                    View Case Details
                </a>
            </center>
        </div>

        <div class="footer">
            <p>This is an automated hearing reminder from the LAO Case Matrix System.</p>
            <p>© {{ date('Y') }} Legal Aid Office - All Rights Reserved</p>
        </div>
    </div>
</body>
</html>
