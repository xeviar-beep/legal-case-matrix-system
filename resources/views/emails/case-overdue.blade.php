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
            background: #dc3545;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border: 2px solid #dc3545;
            border-top: none;
        }
        .alert-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
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
            <h1>🚨 URGENT: CASE OVERDUE</h1>
        </div>
        
        <div class="content">
            <div class="alert-box">
                <strong>⚠️ IMMEDIATE ACTION REQUIRED</strong>
                <p>This case has exceeded its deadline by <strong>{{ $daysOverdue }} day(s)</strong>. Please take immediate action.</p>
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
                    <span>{{ $case->court_agency }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Deadline Date:</span>
                    <span style="color: #dc3545; font-weight: bold;">
                        {{ $case->deadline_date ? \Carbon\Carbon::parse($case->deadline_date)->format('F d, Y') : '-' }}
                        ({{ $daysOverdue }} day(s) ago)
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span>{{ ucfirst($case->status) }}</span>
                </div>
                
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

            <p style="margin-top: 30px; font-size: 14px; color: #6c757d;">
                <strong>Next Steps:</strong><br>
                • Review the case immediately<br>
                • Update the case status<br>
                • Contact the client if necessary<br>
                • Take appropriate legal action
            </p>
        </div>

        <div class="footer">
            <p>This is an automated notification from the LAO Case Matrix System.</p>
            <p>© {{ date('Y') }} Legal Aid Office - All Rights Reserved</p>
        </div>
    </div>
</body>
</html>
