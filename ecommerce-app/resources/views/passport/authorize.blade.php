<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorize — Ecommerce</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            -webkit-font-smoothing: antialiased;
        }

        .shape-coral {
            position: fixed;
            top: -40px; right: -40px;
            width: 130px; height: 130px;
            background: #e85d6a;
            border-radius: 0 0 0 100%;
            z-index: 0;
        }

        .shape-yellow {
            position: fixed;
            bottom: -40px; left: -40px;
            width: 140px; height: 140px;
            background: #f5c842;
            border-radius: 50%;
            z-index: 0;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            width: 100%;
            max-width: 460px;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .card-top {
            background: #2ec4b6;
            padding: 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-top::before {
            content: '';
            position: absolute;
            bottom: -30px; left: -30px;
            width: 100px; height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,.1);
        }

        .card-top::after {
            content: '';
            position: absolute;
            top: -20px; right: 40px;
            width: 60px; height: 60px;
            background: rgba(255,255,255,.1);
            transform: rotate(45deg);
        }

        .connect-icons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
        }

        .app-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.2);
            border: 1.5px solid rgba(255,255,255,.4);
        }

        .connect-arrow {
            color: rgba(255,255,255,.7);
        }

        .card-top h2 {
            font-size: 20px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 6px;
            position: relative;
            z-index: 1;
        }

        .card-top p {
            font-size: 13px;
            color: rgba(255,255,255,.78);
            position: relative;
            z-index: 1;
        }

        .card-body {
            padding: 28px 32px;
        }

        .client-name {
            font-size: 15px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 4px;
        }

        .permission-label {
            font-size: 12px;
            font-weight: 600;
            color: #a0aec0;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 12px;
            margin-top: 20px;
        }

        .scope-list {
            list-style: none;
            margin-bottom: 28px;
        }

        .scope-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            background: #f8fafc;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 13.5px;
            color: #4a5568;
            font-weight: 500;
        }

        .scope-check {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #e8faf8;
            border: 1px solid #b2ede9;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #2ec4b6;
        }

        .default-scope {
            font-size: 13px;
            color: #718096;
            background: #f8fafc;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        .btn-row {
            display: flex;
            gap: 12px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: all .18s;
        }

        .btn-approve {
            background: #2ec4b6;
            color: #fff;
        }

        .btn-approve:hover {
            background: #25a99d;
            transform: translateY(-1px);
        }

        .btn-deny {
            background: #f4f6f8;
            color: #718096;
            border: 1.5px solid #e8ecf0;
        }

        .btn-deny:hover {
            background: #fff5f6;
            color: #e85d6a;
            border-color: #fecdd3;
        }

        .security-note {
            text-align: center;
            font-size: 11.5px;
            color: #a0aec0;
            margin-top: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
    </style>
</head>
<body>

<div class="shape-coral"></div>
<div class="shape-yellow"></div>

<div class="card">

    <div class="card-top">
        <div class="connect-icons">
            <div class="app-icon">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1" fill="white" opacity=".9"/>
                    <rect x="14" y="3" width="7" height="7" rx="1" fill="white" opacity=".7"/>
                    <rect x="3" y="14" width="7" height="7" rx="1" fill="white" opacity=".7"/>
                    <rect x="14" y="14" width="7" height="7" rx="1" fill="white" opacity=".5"/>
                </svg>
            </div>
            <div class="connect-arrow">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </div>
            <div class="app-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2C8 2 4 5 4 9c0 5.25 8 13 8 13s8-7.75 8-13c0-4-4-7-8-7z" fill="white" opacity=".9"/>
                    <circle cx="12" cy="9" r="2.5" fill="#2ec4b6"/>
                </svg>
            </div>
        </div>
        <h2>Authorization Request</h2>
        <p>An application wants to access your account</p>
    </div>

    <div class="card-body">

        <div class="client-name">{{ $client->name }}</div>
        <div style="font-size:13px;color:#718096;margin-bottom:4px">
            is requesting access to your Ecommerce account.
        </div>

        <div class="permission-label">Permissions Requested</div>

        @if(count($scopes) > 0)
            <ul class="scope-list">
                @foreach($scopes as $scope)
                    <li>
                        <span class="scope-check">
                            <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        {{ $scope->description }}
                    </li>
                @endforeach
            </ul>
        @else
            <div class="default-scope">
                <strong>Read your profile information</strong> — name and email address only. No passwords or sensitive data are shared.
            </div>
        @endif

        <div class="btn-row">
            {{-- Deny --}}
            <form method="POST" action="{{ route('passport.authorizations.deny') }}" style="flex:1">
                @csrf
                @method('DELETE')
                <input type="hidden" name="state"            value="{{ $request->state }}">
                <input type="hidden" name="client_id"        value="{{ $client->getKey() }}">
                <input type="hidden" name="auth_token"       value="{{ $authToken }}">
                <button type="submit" class="btn btn-deny" style="width:100%">Deny</button>
            </form>

            {{-- Approve --}}
            <form method="POST" action="{{ route('passport.authorizations.approve') }}" style="flex:1">
                @csrf
                <input type="hidden" name="state"            value="{{ $request->state }}">
                <input type="hidden" name="client_id"        value="{{ $client->getKey() }}">
                <input type="hidden" name="auth_token"       value="{{ $authToken }}">
                <button type="submit" class="btn btn-approve" style="width:100%">Authorize</button>
            </form>
        </div>

        <div class="security-note">
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Secured with OAuth 2.0 · ZaviSoft
        </div>

    </div>
</div>

</body>
</html>
