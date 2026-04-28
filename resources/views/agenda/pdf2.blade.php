<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <title>सर्वसाधारण सभा सूचना</title>
    <style>
        body {
            font-family: "Noto Sans Devanagari", sans-serif;
            margin: 40px;
            line-height: 1.7;
            font-size: 16px;
        }
        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .underline { text-decoration: underline; }
        .mt-20 { margin-top: 20px; }
        .mt-30 { margin-top: 30px; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="center bold underline">
        पनवेल महानगरपालिका, पनवेल
    </div>

    <div class="right mt-20">
        जा. क्र. मनपा/सर्वसाधारण/२०२५-२६/ _______<br>
        पनवेल महानगरपालिका,<br>
        दिनांक : {{ date('d/m/Y', strtotime($agenda->date)) }}
    </div>

    <div class="center bold underline mt-30">
        पनवेल महानगरपालिकेच्या सर्वसाधारण सभेसंबंधी सूचना
    </div>

    <!-- Address -->
    <div class="mt-20">
        प्रति,<br>
        श्री./श्रीमती __________________________<br>
        मा. सदस्यगण,<br>
        पनवेल महानगरपालिका, पनवेल.
    </div>

    <!-- Body -->
    <div class="mt-20">
        महोदय/महोदया,
    </div>

    <div class="mt-20">
        पनवेल महानगरपालिकेची सर्वसाधारण सभा {{ date('d/m/Y', strtotime($agenda->date)) }} रोजी
        {{ date('h:i A', strtotime($agenda->time)) }} वाजता, {{ $agenda->place }} येथे आयोजित करण्यात आली असून,
        त्यामध्ये खालील विषयांवर विचार विनिमय करण्यात येणार आहे.
    </div>

    <!-- Subject -->
    <div class="center bold underline mt-30">
        {{ $agenda->meeting->name ?? '' }}, दिनांक {{ date('d/m/Y', strtotime($agenda->date)) }} ची<br>
        विषय पत्रिका
    </div>

    <!-- Points -->
    <div class="mt-20">
        १. मागील सर्वसाधारण सभेचे इतिवृत्त कायम करणे.<br><br>

        २. प्रश्नोत्तरे.<br><br>

        ३. मा. आयुक्त महोदयांकडील कार्यालीन कामकाज :<br><br>

        @php $count = 1; @endphp
        @foreach($goshwaras as $goshwara)
            @if($goshwara->goshwara?->is_mayor_selected)
            &nbsp;&nbsp;&nbsp;&nbsp;{{ $count++ }}. {{ $goshwara->goshwara->subject }}<br><br>
            @endif
        @endforeach
    </div>

</body>
</html>
