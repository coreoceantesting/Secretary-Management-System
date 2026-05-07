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

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .underline {
            text-decoration: underline;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mt-30 {
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="center bold underline" style="font-size: 26px;">
        पनवेल महानगरपालिका, पनवेल
    </div>

    <div class="right mt-20">
         <div style="display: inline-block; text-align: left; style="font-size: 20px;">
            जा. क्र. पमपा/सचिव/२०-२६/प्र.क्र.०४/१२४/२६<br>
            महापालिका सचिव कार्यालय,<br>
            दिनांक : {{ date('d/m/Y', strtotime($agenda->date)) }}
         </div>
    </div>

    <div class="center bold underline mt-30" style="font-size: 20px;">
        पनवेल महानगरपालिकेच्या {{ $agenda->meeting->name ?? 'सर्वसाधारण सभा' }} संबंधी सूचना
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
        पनवेल महानगरपालिकेची {{ $agenda->meeting->name ?? 'सर्वसाधारण सभा' }}
        {{ date('d/m/Y', strtotime($agenda->date)) }} रोजी
        {{ date('h:i A', strtotime($agenda->time)) }} वाजता, "{{ $agenda->place }}" येथे आयोजित करण्यात आली असून,
        त्यामध्ये खालील विषयांवर विचार विनिमय करण्यात येणार आहे.
    </div>

    <!-- Subject -->
    <div class="center bold underline mt-30" style="font-size: 20px;">
        {{ $agenda->meeting->name ?? '' }}, दिनांक {{ date('d/m/Y', strtotime($agenda->date)) }} ची<br>
        विषय पत्रिका<br>
        विषय
    </div>

    <!-- Points -->
    <div class="mt-20">
        १. मागील {{ $agenda->meeting->name ?? 'सर्वसाधारण सभा' }} चे इतिवृत्त कायम करणे.<br><br>

        २. प्रश्नोत्तरे.<br><br>

        ३. मा. आयुक्त महोदयांकडील कार्यालीन कामकाज :<br><br>

        @php $count = 1; @endphp
        @foreach ($goshwaras as $goshwara)
            @if ($goshwara->goshwara?->is_mayor_selected)
                &nbsp;&nbsp;&nbsp;&nbsp;{{ $count++ }}. {{ $goshwara->goshwara->subject }}<br><br>
            @endif
        @endforeach
    </div>

    <div class="mt-30">
        (मा. महापौर महोदय यांच्या मंजुरीने व आदेशानुसार)
    </div>

    <div class="mt-20" style="text-align: right;">
        @php
            $signature = \App\Models\Signature::getActive();
            $imageData = null;
            if($signature && $signature->image) {
                $fullPath = storage_path('app/public/'.$signature->image);
                if(file_exists($fullPath)) {
                    $imageContent = file_get_contents($fullPath);
                    $imageType = pathinfo($fullPath, PATHINFO_EXTENSION);
                    $imageData = 'data:image/' . $imageType . ';base64,' . base64_encode($imageContent);
                }
            }
        @endphp
        <div style="display: inline-block; text-align: center;">
            @if($imageData)
                <img src="{{ $imageData }}" alt="Signature" style="height: 60px;"><br>
            @endif
            <span class="bold">{{ $signature->name ?? 'मिलिंद कानडे' }}</span><br>
            {{ $signature->role ?? 'महापालिका सचिव' }}<br>
            पनवेल महानगरपालिका
        </div>
    </div>

    <div class="mt-30">
        महापालिका भवन, पनवेल<br>
        दिनांक : {{ date('d/m/Y', strtotime($agenda->date)) }}<br><br>

        सोबत : विषयांचे गोषवारे.
    </div>

</body>

</html>
