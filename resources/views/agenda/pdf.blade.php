<!DOCTYPE html>
<html lang="mr">

<head>
    <meta charset="UTF-8">
    <title>सभेची नोटीस</title>
    <style>
        body {
            font-family: 'freeserif', sans-serif;
            font-size: 16px;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .page-border {
            border: 2px solid #000;
            padding: 30px;
            margin: 20px;
        }

        #header table {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .header-logo {
            width: 120px;
            height: auto;
        }

        .subject-title {
            font-size: 20px;
            font-weight: bold;
            margin: 25px 0 10px;
            text-align: center;
        }

        p {
            text-align: justify;
            margin: 8px 0;
        }

        table td {
            vertical-align: top;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="page-border">
        <!-- Header -->
        <section id="header">
            <table>
                <tr>
                    <td style="width: 20%">
                        @php
                            $logoData = file_get_contents(public_path('admin/images/PMC-logo.png'));
                            $base64Logo = base64_encode($logoData);
                        @endphp
                        <img src="data:image/png;base64,{{ $base64Logo }}" class="header-logo" alt="PMC Logo">
                    </td>
                    <td class="text-center" style="width: 60%">
                        <h2 style="margin: 0;">पनवेल महानगरपालिका</h2>
                        <h3 style="margin: 0;">सभेची नोटीस</h3>
                        <p style="margin: 0;">स्थायी समिती सभा कामकाज पार पाडण्याबाबत</p>
                        <p style="margin: 0;">प्रशासकाची सभा क्र.४७/११४</p>
                        @php
                        $days = ['Monday' => 'सोमवार', 'Tuesday'=>'मंगळवार','Wednesday'=>'बुधवार','Thursday'=>'गुरुवार','Friday'=>'शुक्रवार','Saturday'=>'शनिवार','Sunday'=>'रविवार'];
                        @endphp
                        <p style="margin: 5px 0; font-size: 18px;"><b> {{ $days[date('l', strtotime($agenda->date))] ?? '' }} दिनांक : {{ date('d/m/Y', strtotime($agenda->date)) }}</b></p>
                    </td>
                    <td class="text-right" style="width: 20%">
                        {{-- Optional right-aligned section --}}
                        @php
                            $logoData = file_get_contents(public_path('admin/images/PMC-logo.png'));
                            $base64Logo = base64_encode($logoData);
                        @endphp
                        <img src="data:image/png;base64,{{ $base64Logo }}" class="header-logo" alt="PMC Logo">
                    </td>
                </tr>
            </table>
             <hr style="border: 1px solid #000; margin: 20px 0;">
        </section>

        <!-- Reference Number & Date -->
        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <td style="width: 80%;">जा.क्र.पमपा./सचिव/१९-२४/प्र.क्र.७२/१५/२४</td>
                {{-- <td class="text-right">दिनांक : {{ date('d/m/Y', strtotime($agenda->date)) }}</td> --}}
                {{-- <td style="font-display: none">दिनांक:{{ date('d/m/Y', strtotime($agenda->date)) }}</td> --}}
                <td style="white-space: nowrap;">दिनांक: {{ date('d/m/Y', strtotime($agenda->date)) }}</td>
            </tr>
        </table>
        <br>
        <br>
        <!-- Main Content -->
        <p class="first-line">
        ज्या अर्थी, महाराष्ट्र महानगरपालिका अधिनियमातील तरतुदीनुसार विविध कामकाज पार पाहण्यासाठी काही प्रस्तावांना स्थायी समितीची पूर्व मान्यता घेणे आवश्यक आहे.
       </p>

       <p>
        आणि, ज्या अर्थी, पनवेल महानगरपालिकेची मुदत दिनांक ०९ जुलै, २०२२ रोजी संपलेली असल्याने सद्यः स्थितीत स्थायी समिती अस्तित्वात नाही. आणि,
        ज्या अर्थी, महाराष्ट्र महानगरपालिका अधिनियमाखाली सर्व अधिकारांचा वापर करण्यासाठी आणि तिची सर्व कामे व कर्तव्ये पार पाडण्यासाठी महाराष्ट्र महानगरपालिका अधिनियमातील तरतुदी व विशेषतः कलम ४५२ 'अ' च्या (१ अ) व (१ ब) मधील तरतुदींनुसार पनवेल महानगरपालिका येथे प्रशासक पदी आयुक्त, पनवेल महानगरपालिका यांची नियुक्ती महाराष्ट्र शासनाने केलेली आहे,
        त्या अर्थी, स्थायी समितीच्या मान्यतेने पार पाडावयाचे कामकाज पूर्ण करण्यासाठी प्रशासक यांच्या अध्यक्षतेखाली खालील प्रस्तावांवर निर्णय घेणेकरीता बैठकीचे आयोजन करण्यात येत आहे.
       </p>

        <!-- Meeting Info -->
        <p><b>बैठकीचे स्थळ :</b> {{ $agenda->place }}</p>
        <p><b>दिनांक :</b> {{ date('d/m/Y', strtotime($agenda->date)) }}</p>
        <p><b>वेळ :</b> {{ date('h:i A', strtotime($agenda->time)) }}</p>

        <!-- Subject List -->
        <div class="subject-title">विषय सूची</div>
        @foreach($goshwaras as $goshwara)
            <p>{{ $loop->iteration }}. {{ $goshwara?->goshwara?->subject }}</p>
        @endforeach

        <!-- Footer -->
        <div class="footer">
            मा. प्रशासकाकडील <br> कार्यालयीन कामकाज
        </div>
    </div>
</body>

</html>
