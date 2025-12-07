<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izveštaj o otpadu - {{ $waste->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 0 30px 30px;
        }
        .info-section {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .info-section h2 {
            font-size: 16px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4f46e5;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .info-item {
            margin-bottom: 12px;
        }
        .info-label {
            font-weight: bold;
            color: #6b7280;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 13px;
            color: #111827;
            font-weight: 500;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-prijavljen {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-u-obradi {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .status-preuzet {
            background-color: #d1fae5;
            color: #065f46;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 10px;
        }
        .full-width {
            grid-column: 1 / -1;
        }
        .notes {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin-top: 15px;
            border-radius: 4px;
        }
        .notes-label {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 8px;
        }
        .notes-content {
            color: #78350f;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>IZVEŠTAJ O OTPADU</h1>
        <p>EcoFlow - Digitalni sistem za upravljanje otpadom</p>
    </div>

    <div class="content">
        <!-- Osnovne informacije -->
        <div class="info-section">
            <h2>Osnovne informacije</h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">ID zapisa</div>
                    <div class="info-value">#{{ $waste->id }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Datum izveštaja</div>
                    <div class="info-value">{{ now()->format('d.m.Y H:i') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Kompanija</div>
                    <div class="info-value">{{ $waste->company->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Lokacija</div>
                    <div class="info-value">{{ $waste->location->naziv }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Adresa lokacije</div>
                    <div class="info-value">{{ $waste->location->adresa }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Tip otpada</div>
                    <div class="info-value">{{ $waste->tip_otpada }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Količina</div>
                    <div class="info-value">{{ number_format($waste->kolicina, 2, ',', '.') }} kg</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Datum nastanka</div>
                    <div class="info-value">{{ $waste->datum_nastanka->format('d.m.Y') }}</div>
                </div>
                <div class="info-item full-width">
                    <div class="info-label">Status</div>
                    <div>
                        @if($waste->status === 'Prijavljen')
                            <span class="status-badge status-prijavljen">{{ $waste->status }}</span>
                        @elseif($waste->status === 'U obradi')
                            <span class="status-badge status-u-obradi">{{ $waste->status }}</span>
                        @else
                            <span class="status-badge status-preuzet">{{ $waste->status }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Informacije o preuzimanju -->
        @if($waste->status === 'Preuzet' && $waste->operator)
        <div class="info-section">
            <h2>Informacije o preuzimanju</h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Operator</div>
                    <div class="info-value">{{ $waste->operator->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Datum preuzimanja</div>
                    <div class="info-value">{{ $waste->datum_preuzimanja->format('d.m.Y H:i') }}</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Napomene -->
        @if($waste->napomena)
        <div class="info-section">
            <h2>Napomene</h2>
            <div class="notes">
                <div class="notes-label">Dodatne informacije:</div>
                <div class="notes-content">{{ $waste->napomena }}</div>
            </div>
        </div>
        @endif

        <div class="footer">
            <p>Ovaj izveštaj je automatski generisan od strane sistema EcoFlow.</p>
            <p>Datum generisanja: {{ now()->format('d.m.Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>

