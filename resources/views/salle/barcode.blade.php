<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Imprimer le code-barres</title>

    <style>
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <table width="100%">
        <tr>
            @foreach ($datasalle as $salle)
                <td class="text-center" style="border: 1px solid #333;">
                    <p>{{ $salle->nama_salle }} - $ {{ format_uang($salle->capacite) }}</p>
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($salle->numero, 'C39') }}" 
                        alt="{{ $salle->numero }}"
                        width="180"
                        height="60">
                    <br>
                    {{ $salle->numero }}
                </td>
                @if ($no++ % 3 == 0)
                    </tr><tr>
                @endif
            @endforeach
        </tr>
    </table>
</body>
</html>