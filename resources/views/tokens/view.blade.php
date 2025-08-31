<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Token - {{ $token->token_code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .token-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
            position: relative;
        }

        .token-header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }

        .brand-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .brand-subtitle {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 300;
        }

        .token-body {
            padding: 30px 20px;
            text-align: center;
        }

        .token-code {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            border-radius: 15px;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 25px;
            letter-spacing: 2px;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .customer-info {
            margin-bottom: 25px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #666;
            text-align: left;
        }

        .info-value {
            font-weight: 500;
            color: #333;
            text-align: right;
        }

        .amount-section {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
        }

        .amount-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .amount-value {
            font-size: 32px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-generated {
            background: #f39c12;
            color: white;
        }

        .status-used {
            background: #27ae60;
            color: white;
        }

        .token-footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .date-info {
            color: #666;
            font-size: 14px;
        }

        .print-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        .print-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        /* Print styles - maintain the same beautiful design */
        @media print {
            body {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                min-height: 100vh !important;
            }

            .token-container {
                box-shadow: none !important;
                border: 2px solid #333 !important;
                margin: 0 auto !important;
                max-width: 400px !important;
                width: 100% !important;
                border-radius: 20px !important;
                overflow: hidden !important;
                position: relative !important;
            }

            .token-header {
                background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%) !important;
                color: white !important;
                padding: 30px 20px !important;
                text-align: center !important;
                position: relative !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            .token-body {
                padding: 30px 20px !important;
                text-align: center !important;
            }

            .token-code {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                color: white !important;
                padding: 15px !important;
                border-radius: 15px !important;
                font-size: 18px !important;
                font-weight: bold !important;
                margin-bottom: 25px !important;
                letter-spacing: 2px !important;
                box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4) !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            .customer-info {
                margin-bottom: 25px !important;
            }

            .info-row {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                padding: 12px 0 !important;
                border-bottom: 1px solid #f0f0f0 !important;
            }

            .info-row:last-child {
                border-bottom: none !important;
            }

            .info-label {
                font-weight: 600 !important;
                color: #666 !important;
                text-align: left !important;
            }

            .info-value {
                font-weight: 500 !important;
                color: #333 !important;
                text-align: right !important;
            }

            .amount-section {
                background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%) !important;
                color: white !important;
                padding: 20px !important;
                border-radius: 15px !important;
                margin-bottom: 25px !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            .amount-label {
                font-size: 14px !important;
                opacity: 0.9 !important;
                margin-bottom: 5px !important;
            }

            .amount-value {
                font-size: 32px !important;
                font-weight: bold !important;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3) !important;
            }

            .status-badge {
                display: inline-block !important;
                padding: 8px 16px !important;
                border-radius: 25px !important;
                font-size: 12px !important;
                font-weight: 600 !important;
                text-transform: uppercase !important;
                letter-spacing: 1px !important;
            }

            .status-badge.status-generated {
                background: #f39c12 !important;
                color: white !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            .status-badge.status-used {
                background: #27ae60 !important;
                color: white !important;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            .token-footer {
                background: #f8f9fa !important;
                padding: 20px !important;
                text-align: center !important;
                border-top: 1px solid #e9ecef !important;
            }

            .date-info {
                color: #666 !important;
                font-size: 14px !important;
            }

            .print-button {
                display: none !important;
            }

            /* Ensure gradients and colors print properly */
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
        }

        @media (max-width: 480px) {
            .token-container {
                margin: 10px;
            }
            .brand-name {
                font-size: 20px;
            }
            .amount-value {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="token-container">
        <div class="token-header">
            <div class="brand-name">GOD DOM PARK</div>
            <div class="brand-subtitle">Your Final Destination for All your needs</div>
        </div>

        <div class="token-body">
            <div class="token-code">
                {{ $token->token_code }}
            </div>

            <div class="customer-info">
                <div class="info-row">
                    <span class="info-label">Customer Name:</span>
                    <span class="info-value">{{ $token->customer_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Contact Number:</span>
                    <span class="info-value">{{ $token->contact_number }}</span>
                </div>
            </div>

            <div class="amount-section">
                <div class="amount-label">Token Amount</div>
                <div class="amount-value">₹{{ number_format($token->balance_amount, 2) }}</div>
            </div>

            <div class="status-badge status-{{ $token->status }}">
                {{ ucfirst($token->status) }}
            </div>
        </div>

        <div class="token-footer">
            <div class="date-info">
                Generated on: {{ $token->created_at->format('d M Y, h:i A') }}
            </div>
            @if($token->status === 'used')
                <div class="date-info" style="margin-top: 5px;">
                    Used on: {{ $token->updated_at->format('d M Y, h:i A') }}
                </div>
            @endif
            <button class="print-button" onclick="window.print()">
                🖨️ Print Token
            </button>
        </div>
    </div>

    <script>
        // Auto-print functionality (optional)
        // window.onload = function() {
        //     if (window.location.search.includes('autoprint=1')) {
        //         window.print();
        //     }
        // };
    </script>
</body>
</html>
