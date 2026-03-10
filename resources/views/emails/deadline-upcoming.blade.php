<!DOCTYPE html>
<html>
<head>
    <?php
        $headerBg = $urgency === 'today' ? '#ffc107' : ($urgency === 'tomorrow' ? '#17a2b8' : '#6c757d');
        $headerColor = $urgency === 'today' ? '#000' : '#fff';
        $borderColor = $urgency === 'today' ? '#ffc107' : ($urgency === 'tomorrow' ? '#17a2b8' : '#6c757d');
        $alertBg = $urgency === 'today' ? '#fff3cd' : '#d1ecf1';
        $alertBorder = $urgency === 'today' ? '#ffc107' : '#17a2b8';
        $urgencyColor = $urgency === 'today' ? '#ffc107' : '#17a2b8';
    ?>
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
            background: <?php echo $headerBg; ?>;
            color: <?php echo $headerColor; ?>;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border: 2px solid <?php echo $borderColor; ?>;
            border-top: none;
        }
        .alert-box {
            background: <?php echo $alertBg; ?>;
            border-left: 4px solid <?php echo $alertBorder; ?>;
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
            <h1>
                @if($urgency === 'today')
                    ⏰ DEADLINE TODAY
                @elseif($urgency === 'tomorrow')
                    📅 DEADLINE TOMORROW
                @else
                    📌 UPCOMING DEADLINE
                @endif
            </h1>
        </div>
        
        <div class="content">
            <div class="alert-box">
                <strong>
                    @if($urgency === 'today')
                        ⚠️ Action Required Today
                    @elseif($urgency === 'tomorrow')
                        📢 Deadline in 24 Hours
                    @else
                        📋 Advance Notice - 3 Days
                    @endif
                </strong>
                <p>
                    @if($urgency === 'today')
                        The deadline for this case is <strong>TODAY</strong>. Please ensure all necessary actions are completed.
                    @elseif($urgency === 'tomorrow')
                        The deadline for this case is <strong>TOMORROW</strong>. Please prepare and finalize all requirements.
                    @else
                        The deadline for this case is in <strong>3 DAYS</strong>. This is an advance notice to help you prepare.
                    @endif
                </p>
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
                    <span style="color: <?php echo $urgencyColor; ?>; font-weight: bold;">
                        {{ $case->deadline_date ? \Carbon\Carbon::parse($case->deadline_date)->format('F d, Y (l)') : '-' }}
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Days Remaining:</span>
                    <span style="font-weight: bold; color: <?php echo $urgencyColor; ?>;">
                        @if($urgency === 'today')
                            TODAY
                        @elseif($urgency === 'tomorrow')
                            1 Day
                        @else
                            3 Days
                        @endif
                    </span>
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
                <strong>Recommended Actions:</strong><br>
                • Review all case documents<br>
                • Prepare required submissions<br>
                • Confirm all deadlines and requirements<br>
                • Update case status after completion
            </p>
        </div>

        <div class="footer">
            <p>This is an automated deadline reminder from the LAO Case Matrix System.</p>
            <p>© {{ date('Y') }} Legal Aid Office - All Rights Reserved</p>
        </div>
    </div>
</body>
</html>
