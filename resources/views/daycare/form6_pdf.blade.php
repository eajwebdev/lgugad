<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Form 6 - Child Development Worker Profile</title>
{{--
    ECCD Council Form 6 (April 2014), A4. Every label, rule and checkbox is placed at the point
    coordinates of the official form so the output matches it line for line. Arial and Times New Roman
    are drawn with their metric-identical PDF core fonts (Helvetica, Times); the Calibri title uses
    Carlito, its metric-compatible open-licensed twin.
--}}
<style>
@font-face {
    font-family: 'Carlito';
    font-weight: bold;
    src: url('{{ str_replace('\\', '/', resource_path('fonts/Carlito-Bold.ttf')) }}') format('truetype');
}
@page { margin: 0; }
body { margin: 0; color: #000; }
.page { position: relative; width: 595.44pt; height: 841.68pt; overflow: hidden; page-break-after: always; }
.page-last { page-break-after: auto; }
.t, .v, .tick { position: absolute; white-space: nowrap; line-height: 1; }
.t { font-family: Helvetica; font-size: 11.04pt; }
.t-b { font-weight: bold; }
.t-i { font-style: italic; font-size: 9pt; }
.t-times { font-family: Times; }
.t-title { font-family: 'Carlito'; font-weight: bold; font-size: 14.04pt; }
.v { font-family: Helvetica; overflow: hidden; }
.r { position: absolute; background: #000; font-size: 0; line-height: 0; }
.cb { position: absolute; border: 0.48pt solid #000; font-size: 0; line-height: 0; }
.tick { font-family: 'DejaVu Sans'; font-weight: bold; font-size: 11pt; }
</style>
</head>
<body>
@php
    $w = $worker;
    $n = fn ($v) => rtrim(rtrim(sprintf('%.2F', $v), '0'), '.');

    // Filled rectangle by its corners (rules, table grid).
    $rule = fn ($x0, $y0, $x1, $y1) => '<div class="r" style="left:' . $n($x0) . 'pt;top:' . $n($y0) . 'pt;width:' . $n($x1 - $x0) . 'pt;height:' . $n($y1 - $y0) . 'pt"></div>';
    // Stroked line of the given width, centred on the coordinates.
    $hline = fn ($x0, $x1, $y, $width = 3) => $rule($x0, $y - $width / 2, $x1, $y + $width / 2);
    $vline = fn ($x, $y0, $y1, $width = 3) => $rule($x - $width / 2, $y0, $x + $width / 2, $y1);

    // Checkbox by its outer corners, ticked when $on.
    $box = function ($x0, $y0, $x1, $y1, $on = false) use ($n) {
        $html = '<div class="cb" style="left:' . $n($x0) . 'pt;top:' . $n($y0) . 'pt;width:' . $n($x1 - $x0 - 0.96) . 'pt;height:' . $n($y1 - $y0 - 0.96) . 'pt"></div>';
        if ($on) {
            // DejaVu Sans Bold 11pt check mark: 9.22pt wide, baseline 11.27pt below the box top.
            $html .= '<div class="tick" style="left:' . $n($x0 + ($x1 - $x0 - 9.22) / 2) . 'pt;top:' . $n(($y0 + $y1) / 2 + 4 - 11.27) . 'pt">&#10003;</div>';
        }

        return $html;
    };

    // Filled-in value: left edge, baseline and available width in points. Long values shrink to fit the line.
    $metrics = app('dompdf')->getFontMetrics();
    $helvetica = $metrics->getFont('helvetica');
    $val = function ($x, $baseline, $width, $text, $size = 10) use ($n, $metrics, $helvetica) {
        $text = trim((string) $text);
        if ($text === '') {
            return '';
        }
        $textWidth = $metrics->getTextWidth($text, $helvetica, $size);
        if ($textWidth > $width - 1) {
            $size = max(6, $size * ($width - 1) / $textWidth);
        }

        return '<div class="v" style="left:' . $n($x) . 'pt;top:' . $n($baseline - 0.8173 * $size) . 'pt;width:' . $n($width) . 'pt;font-size:' . $n($size) . 'pt">' . e($text) . '</div>';
    };

    $is = fn ($attribute, $value) => (string) $w->{$attribute} === (string) $value;
    $has = fn ($attribute, $value) => $w->hasChoice($attribute, $value);
    $money = fn ($amount) => $amount === null ? '' : number_format((float) $amount, 2);
    $date = fn ($value, $format = 'm/d/Y') => $value?->format($format) ?? '';
    $trainings = $w->trainings ?? [];
    $courses = $w->other_courses ?? [];
@endphp

{{-- ============================== Page 1 ============================== --}}
<div class="page">
    <div class="t t-times" style="left:193.01pt;top:37.79pt">Early Childhood Care and Development Council</div>
    {!! $hline(54.8, 546.0, 53.2, 1) !!}
    <div class="t t-title" style="left:55.2pt;top:55.11pt">FORM 6 &ndash; CHILD DEVELOPMENT WORKER PROFILE</div>

    {!! $hline(47.4, 547.2, 77.1) !!}
    {!! $vline(48.0, 76.1, 579.2) !!}
    {!! $vline(546.6, 75.1, 578.2) !!}
    {!! $hline(46.8, 546.6, 577.4) !!}
    {!! $vline(48.0, 542.3, 781.7) !!}
    {!! $vline(546.6, 543.2, 782.5) !!}
    {!! $hline(47.4, 546.0, 781.0) !!}

    {{-- I. Personal information --}}
    <div class="t t-b" style="left:57.6pt;top:85.68pt">I.</div>
    <div class="t t-b" style="left:75.62pt;top:85.68pt">Child Development Worker Personal Information</div>

    <div class="t" style="left:76.58pt;top:111.6pt">Name:</div>
    {!! $rule(113.7, 123.1, 325.6, 123.6) !!}
    {!! $val(114.5, 120.62, 210, $w->form_name) !!}
    <div class="t" style="left:331.03pt;top:111.6pt">Age:</div>
    {!! $rule(358.4, 123.1, 390.1, 123.6) !!}
    {!! $val(359.5, 120.62, 30, $w->age) !!}
    <div class="t" style="left:395.47pt;top:111.6pt">Sex:</div>
    {!! $box(422.7, 109.9, 441.1, 123.6, $is('sex', 'Male')) !!}
    <div class="t" style="left:446.26pt;top:111.6pt">Male</div>
    {!! $box(475.7, 109.9, 494.9, 123.6, $is('sex', 'Female')) !!}
    <div class="t" style="left:500.02pt;top:111.6pt">Female</div>
    <div class="t t-i" style="left:57.6pt;top:124.57pt">(Last name) (First name) (Middle Name)</div>

    <div class="t" style="left:81.02pt;top:147.84pt">Birthday:</div>
    {!! $rule(129.1, 159.3, 228.6, 159.7) !!}
    {!! $val(130, 156.86, 98, $date($w->birthday)) !!}
    <div class="t" style="left:234.41pt;top:147.84pt">Religion:</div>
    {!! $rule(281.9, 159.3, 368.2, 159.7) !!}
    {!! $val(282.8, 156.86, 85, $w->religion) !!}
    <div class="t" style="left:385.63pt;top:147.84pt">Ethnicity:</div>
    {!! $rule(435.0, 159.3, 516.7, 159.7) !!}
    {!! $val(435.9, 156.86, 80, $w->ethnicity) !!}

    <div class="t" style="left:81.02pt;top:179.88pt">Civil Status:</div>
    {!! $box(158.8, 178.2, 177.0, 191.8, $is('civil_status', 'Single')) !!}
    <div class="t" style="left:182.21pt;top:179.88pt">Single</div>
    {!! $box(218.0, 178.2, 236.2, 191.8, $is('civil_status', 'Married')) !!}
    <div class="t" style="left:241.37pt;top:179.88pt">Married</div>
    {!! $box(284.7, 178.2, 301.3, 191.8, $is('civil_status', 'Separated')) !!}
    <div class="t" style="left:306.43pt;top:179.88pt">Separated</div>
    {!! $box(362.4, 178.2, 378.9, 191.8, $is('civil_status', 'Widow/Widower')) !!}
    <div class="t" style="left:384.07pt;top:179.88pt">Widow/Widower</div>
    {!! $box(468.1, 178.2, 483.3, 191.8, $is('civil_status', 'Live in')) !!}
    <div class="t" style="left:488.5pt;top:179.88pt">Live in</div>

    <div class="t" style="left:81.02pt;top:211.44pt">No. Children:</div>
    {!! $rule(155.9, 222.9, 260.2, 223.3) !!}
    {!! $val(156.8, 220.46, 103, $w->no_children) !!}

    <div class="t" style="left:75.62pt;top:255.6pt">Address:</div>
    {!! $rule(124.5, 267.0, 531.1, 267.5) !!}
    {!! $val(125.4, 264.62, 120, trim($w->address_no . ' ' . $w->address_street)) !!}
    {!! $val(248.33, 264.62, 282, $w->address_barangay) !!}
    <div class="t t-i" style="left:75.62pt;top:268.48pt">(No) (Street)</div>
    <div class="t t-i" style="left:248.33pt;top:268.48pt">(Subdivision/Barangay)</div>
    {!! $rule(124.5, 290.6, 530.3, 291.0) !!}
    {!! $val(125.4, 288.2, 145, implode(', ', array_filter([$w->address_city, $w->address_province]))) !!}
    {!! $val(272.63, 288.2, 257, $w->address_region) !!}
    <div class="t t-i" style="left:75.62pt;top:292.0pt">(City/Municipality) (Province)</div>
    <div class="t t-i" style="left:272.63pt;top:292.0pt">(Region)</div>

    <div class="t" style="left:75.62pt;top:315.27pt">Contact Details:</div>
    <div class="t" style="left:75.62pt;top:340.59pt">Home Nos.</div>
    {!! $rule(142.5, 352.0, 215.2, 352.5) !!}
    {!! $val(143.4, 349.61, 72, $w->home_no) !!}
    <div class="t" style="left:220.61pt;top:340.59pt">Office Nos.:</div>
    {!! $rule(286.5, 352.0, 377.2, 352.5) !!}
    {!! $val(287.4, 349.61, 90, $w->office_no) !!}
    <div class="t" style="left:382.63pt;top:340.59pt">Mobile Nos:</div>
    {!! $rule(448.5, 352.0, 530.3, 352.5) !!}
    {!! $val(449.4, 349.61, 81, $w->mobile_no) !!}
    <div class="t" style="left:75.62pt;top:366.39pt">Fax Number:</div>
    {!! $rule(146.9, 377.8, 282.6, 378.3) !!}
    {!! $val(147.8, 375.41, 135, $w->fax_no) !!}
    <div class="t" style="left:288.05pt;top:366.39pt">Email Address:</div>
    {!! $rule(367.5, 377.8, 521.2, 378.3) !!}
    {!! $val(368.4, 375.41, 153, $w->email) !!}

    <div class="t" style="left:71.18pt;top:404.79pt">Educational Background:</div>
    {!! $box(70.9, 428.9, 89.3, 442.5, $is('education', 'Elem. Undergraduate')) !!}
    <div class="t" style="left:94.46pt;top:430.59pt">Elem. Undergraduate</div>
    {!! $box(241.9, 428.9, 259.5, 442.5, $is('education', 'Elem. Graduate')) !!}
    <div class="t" style="left:264.65pt;top:430.59pt">Elem. Graduate</div>
    {!! $box(390.3, 428.9, 409.5, 442.5, $is('education', 'College Graduate')) !!}
    <div class="t" style="left:414.67pt;top:430.59pt">College Graduate</div>
    {!! $box(70.9, 442.0, 89.3, 455.7, $is('education', 'HS Undergraduate')) !!}
    <div class="t" style="left:94.46pt;top:443.79pt">HS Undergraduate</div>
    {!! $box(241.9, 442.0, 259.5, 455.7, $is('education', 'HS Graduate')) !!}
    <div class="t" style="left:264.65pt;top:443.79pt">HS Graduate</div>
    <div class="t" style="left:414.67pt;top:443.79pt">Degree:</div>
    {!! $rule(459.3, 455.2, 539.3, 455.7) !!}
    {!! $val(460.2, 452.81, 79, $w->degree, 9) !!}
    {!! $box(70.9, 455.2, 89.3, 468.9, $is('education', 'With Masteral Units')) !!}
    <div class="t" style="left:94.46pt;top:456.89pt">With Masteral Units</div>
    {!! $box(241.9, 455.2, 259.5, 468.9, $is('education', 'College Undergraduate')) !!}
    <div class="t" style="left:264.65pt;top:456.89pt">College Undergraduate</div>
    {!! $box(70.9, 468.4, 89.3, 482.0, $is('education', 'Post Graduate')) !!}
    <div class="t" style="left:94.46pt;top:470.09pt">Post Graduate</div>
    {!! $box(241.9, 468.4, 259.5, 482.0, $is('education', 'Vocational')) !!}
    <div class="t" style="left:264.65pt;top:470.09pt">Vocational</div>

    <div class="t" style="left:71.18pt;top:508.49pt">Eligibility:</div>
    {!! $box(70.9, 532.6, 89.4, 546.3, $has('eligibility', 'Civil Service Sub-Professional')) !!}
    <div class="t" style="left:94.58pt;top:534.29pt">Civil Service Sub-Professional</div>
    {!! $box(278.0, 532.6, 296.4, 546.3, $has('eligibility', 'Civil Service Professional')) !!}
    <div class="t" style="left:301.63pt;top:534.29pt">Civil Service Professional</div>
    {!! $box(431.0, 532.6, 449.5, 546.3, $has('eligibility', 'None')) !!}
    <div class="t" style="left:454.66pt;top:534.29pt">None</div>
    {!! $box(70.9, 545.8, 89.4, 559.4, $has('eligibility', 'Licensure Examination for Teachers')) !!}
    <div class="t" style="left:94.58pt;top:547.49pt">Licensure Examination for Teachers</div>
    {!! $box(278.0, 545.8, 296.4, 559.4, $has('eligibility', 'Others')) !!}
    <div class="t" style="left:301.63pt;top:547.49pt">Others, pls. specify:</div>
    {!! $rule(403.5, 558.9, 525.7, 559.4) !!}
    {!! $val(404.4, 556.51, 121, $w->eligibility_other, 9) !!}

    {{-- II. Work-related information --}}
    <div class="t t-b" style="left:57.6pt;top:595.01pt">II.</div>
    <div class="t t-b" style="left:75.62pt;top:595.01pt">Work-Related Information</div>

    <div class="t" style="left:75.62pt;top:620.45pt">1.</div>
    <div class="t" style="left:93.62pt;top:620.45pt">Number of Years as Child Development Worker: ___________________</div>
    {!! $val(334, 629.1, 112, $w->years_as_cdw) !!}
    <div class="t" style="left:75.62pt;top:645.68pt">2.</div>
    <div class="t" style="left:93.62pt;top:645.68pt">Name of Child Development Center Being</div>
    <div class="t" style="left:93.62pt;top:658.4pt">Served:___________________________________</div>
    {!! $val(133.5, 667.1, 211, $w->center_name) !!}
    <div class="t" style="left:75.62pt;top:683.72pt">3.</div>
    <div class="t" style="left:93.62pt;top:683.72pt">Monthly Compensation:</div>
    {!! $box(93.4, 707.7, 111.9, 721.4, $has('compensation_types', 'Salary')) !!}
    <div class="t" style="left:117.02pt;top:709.52pt">Salary</div>
    {!! $box(156.4, 707.7, 174.6, 721.4, $has('compensation_types', 'Honoraria')) !!}
    <div class="t" style="left:179.69pt;top:709.52pt">Honoraria</div>
    {!! $box(237.4, 707.7, 255.9, 721.4, $has('compensation_types', 'Allowance')) !!}
    <div class="t" style="left:261.05pt;top:709.52pt">Allowance</div>
    {!! $box(327.4, 707.7, 345.9, 721.4, $has('compensation_types', "Parents' Monthly Contribution/Pledges")) !!}
    <div class="t" style="left:351.07pt;top:709.52pt">Parents&rsquo; Monthly Contribution/Pledges</div>
    <div class="t" style="left:75.62pt;top:735.31pt">4.</div>
    <div class="t" style="left:93.62pt;top:735.31pt">Total Amount of Compensation per Month: _________________</div>
    {!! $val(306, 744.0, 100, $money($w->total_compensation)) !!}

    <div class="t t-times" style="left:57.6pt;top:803.72pt">April 2014</div>
    <div class="t t-times" style="left:479.74pt;top:803.72pt">Page 1&nbsp; of&nbsp; 3</div>
</div>

{{-- ============================== Page 2 ============================== --}}
<div class="page">
    {!! $hline(60.6, 560.4, 96.6) !!}
    {!! $vline(61.2, 96.8, 770.6) !!}
    {!! $vline(559.0, 95.5, 769.3) !!}
    {!! $hline(60.0, 559.8, 768.7) !!}

    <div class="t" style="left:75.62pt;top:123.84pt">5.</div>
    <div class="t" style="left:93.62pt;top:123.84pt">Source of Compensation:</div>
    {!! $box(93.4, 160.6, 111.9, 174.1, $has('compensation_sources', 'barangay')) !!}
    <div class="t" style="left:117.02pt;top:162.24pt">Barangay:</div>
    <div class="t" style="left:181.37pt;top:162.24pt">Amount:</div>
    {!! $rule(236.6, 173.7, 300.7, 174.1) !!}
    {!! $val(237.5, 171.26, 63, $money($w->amount_barangay), 9.5) !!}
    {!! $box(314.0, 160.6, 332.5, 174.1, $has('compensation_sources', 'city')) !!}
    <div class="t" style="left:337.63pt;top:162.24pt">City/Municipal:</div>
    <div class="t" style="left:423.1pt;top:162.24pt">Amount:</div>
    {!! $rule(471.7, 173.7, 525.7, 174.1) !!}
    {!! $val(472.6, 171.26, 53, $money($w->amount_city), 9.5) !!}
    {!! $box(93.4, 173.7, 111.9, 187.3, $has('compensation_sources', 'ngo')) !!}
    <div class="t" style="left:117.02pt;top:175.44pt">NGOs/NGAs:</div>
    <div class="t" style="left:196.97pt;top:175.44pt">Amount:</div>
    {!! $rule(243.3, 186.9, 302.0, 187.3) !!}
    {!! $val(244.2, 184.46, 57, $money($w->amount_ngo), 9.5) !!}
    {!! $box(314.0, 173.7, 332.5, 187.3, $has('compensation_sources', 'parents')) !!}
    <div class="t" style="left:337.63pt;top:175.44pt">Parents :</div>
    <div class="t" style="left:425.02pt;top:175.44pt">Amount:</div>
    {!! $rule(471.0, 186.9, 525.7, 187.3) !!}
    {!! $val(471.9, 184.46, 53, $money($w->amount_parents), 9.5) !!}
    <div class="t" style="left:93.62pt;top:213.84pt">Others, please specify: ____________________</div>
    {!! $val(210.5, 222.5, 120, $w->source_others) !!}

    <div class="t" style="left:75.62pt;top:251.76pt">6.</div>
    <div class="t" style="left:93.62pt;top:251.76pt">Terms of Employment:</div>
    {!! $box(93.4, 288.5, 111.9, 302.2, $is('employment_term', 'Plantilla')) !!}
    <div class="t" style="left:117.02pt;top:290.31pt">Plantilla</div>
    {!! $box(300.4, 288.5, 318.9, 302.2, $is('employment_term', 'Contract of Service')) !!}
    <div class="t" style="left:324.07pt;top:290.31pt">Contract of Service</div>
    {!! $box(430.1, 288.5, 448.5, 302.2, $is('employment_term', 'Casual')) !!}
    <div class="t" style="left:453.7pt;top:290.31pt">Casual</div>
    {!! $box(93.4, 301.7, 111.9, 315.4, $is('employment_term', 'Co-Terminus w/ Hiring Authority')) !!}
    <div class="t" style="left:117.02pt;top:303.39pt">Co-Terminus w/ Hiring Authority</div>
    {!! $box(300.4, 301.7, 318.9, 315.4, $is('employment_term', 'Voluntary')) !!}
    <div class="t" style="left:324.07pt;top:303.39pt">Voluntary</div>

    <div class="t" style="left:75.62pt;top:354.51pt">7.</div>
    <div class="t" style="left:93.62pt;top:354.51pt">ECCD-Related Trainings:</div>
    @foreach ([391.2, 417.0, 430.2, 443.3, 456.5, 469.8] as $y)
        {!! $rule(93.4, $y, 544.0, $y + 0.5) !!}
    @endforeach
    @foreach ([93.4, 309.4, 381.4, 422.0, 543.5] as $x)
        {!! $rule($x, 391.2, $x + 0.5, 470.2) !!}
    @endforeach
    <div class="t" style="left:163.7pt;top:399.27pt">Title of Training</div>
    <div class="t" style="left:324.31pt;top:392.91pt">Inclusive</div>
    <div class="t" style="left:331.27pt;top:405.63pt">Dates</div>
    <div class="t" style="left:387.19pt;top:392.91pt">No. of</div>
    <div class="t" style="left:387.19pt;top:405.63pt">Hours</div>
    <div class="t" style="left:453.22pt;top:392.91pt">Conducted /</div>
    <div class="t" style="left:448.42pt;top:405.63pt">Sponsored By</div>
    @foreach ([427.73, 440.93, 454.01, 467.23] as $i => $baseline)
        <div class="t" style="left:99.02pt;top:{{ $n($baseline - 9.02) }}pt">{{ $i + 1 }}.</div>
        @php $training = $trainings[$i] ?? []; @endphp
        {!! $val(111.5, $baseline - 0.6, 197, $training['title'] ?? '', 8.5) !!}
        {!! $val(311.3, $baseline - 0.6, 69, $training['dates'] ?? '', 8) !!}
        {!! $val(383.3, $baseline - 0.6, 38, isset($training['hours']) ? $n($training['hours']) : '', 8.5) !!}
        {!! $val(424.3, $baseline - 0.6, 118, $training['sponsor'] ?? '', 8) !!}
    @endforeach

    <div class="t" style="left:75.62pt;top:496.61pt">8.</div>
    <div class="t" style="left:93.62pt;top:496.61pt">Other Courses Attended:</div>
    <div class="t" style="left:99.02pt;top:534.65pt">Course</div>
    {!! $rule(144.1, 546.1, 350.2, 546.5) !!}
    {!! $val(145, 543.67, 205, $courses[0]['course'] ?? '') !!}
    <div class="t" style="left:364.27pt;top:534.65pt">Year Completed</div>
    {!! $rule(449.0, 546.1, 534.7, 546.5) !!}
    {!! $val(449.9, 543.67, 84, $courses[0]['year'] ?? '') !!}
    <div class="t" style="left:99.02pt;top:547.73pt">Course</div>
    {!! $rule(143.4, 559.3, 350.2, 559.8) !!}
    {!! $val(144.3, 556.75, 205, $courses[1]['course'] ?? '') !!}
    <div class="t" style="left:364.27pt;top:547.73pt">Year Completed</div>
    {!! $rule(448.3, 559.3, 534.7, 559.8) !!}
    {!! $val(449.2, 556.75, 85, $courses[1]['year'] ?? '') !!}

    <div class="t" style="left:75.62pt;top:586.25pt">9.</div>
    <div class="t" style="left:93.62pt;top:586.25pt">Status as a Child Development Worker:</div>
    {!! $box(94.3, 623.0, 113.7, 636.7, $is('accreditation_status', 'Accredited')) !!}
    <div class="t" style="left:125.18pt;top:624.65pt">Accredited</div>
    {!! $box(202.4, 623.0, 220.9, 636.7, $is('accreditation_status', 'Not Accredited')) !!}
    <div class="t" style="left:233.09pt;top:624.65pt">Not Accredited</div>
    {!! $box(328.4, 623.0, 346.9, 636.7, $is('accreditation_status', 'Accredited but Expired')) !!}
    <div class="t" style="left:364.51pt;top:624.65pt">Accredited but Expired</div>
    <div class="t" style="left:93.62pt;top:663.08pt">Date Accredited ________</div>
    {!! $val(175.6, 671.7, 48.4, $date($w->date_accredited), 8.5) !!}
    <div class="t" style="left:233.21pt;top:663.08pt">Accreditation No. _____________</div>
    {!! $val(320.6, 671.7, 79, $w->accreditation_no, 9) !!}
    <div class="t" style="left:93.98pt;top:701.6pt">Level</div>
    {!! $box(142.9, 699.9, 161.4, 713.5, $is('accreditation_level', 1)) !!}
    <div class="t" style="left:166.58pt;top:701.6pt">1</div>
    {!! $box(196.5, 699.9, 215.4, 713.5, $is('accreditation_level', 2)) !!}
    <div class="t" style="left:220.61pt;top:701.6pt">2</div>
    {!! $box(251.0, 699.9, 269.4, 713.5, $is('accreditation_level', 3)) !!}
    <div class="t" style="left:274.61pt;top:701.6pt">3</div>

    <div class="t t-times" style="left:57.6pt;top:803.72pt">April 2014</div>
    <div class="t t-times" style="left:479.74pt;top:803.72pt">Page 2&nbsp; of&nbsp; 3</div>
</div>

{{-- ============================== Page 3 ============================== --}}
<div class="page page-last">
    {!! $hline(45.7, 545.5, 95.1) !!}
    {!! $vline(46.2, 94.4, 473.7) !!}
    {!! $vline(544.8, 93.6, 472.9) !!}
    {!! $hline(45.0, 544.8, 472.4) !!}

    {{-- III. Working conditions --}}
    <div class="t t-b" style="left:57.6pt;top:130.56pt">III.</div>
    <div class="t t-b" style="left:75.62pt;top:130.56pt">Working Conditions</div>

    <div class="t" style="left:71.18pt;top:168.6pt">1.</div>
    <div class="t" style="left:93.74pt;top:168.6pt">Total No. of ChildrenBeing Served:</div>
    {!! $rule(277.5, 181.3, 401.5, 181.8) !!}
    {!! $val(278.4, 177.62, 122, $w->children_served) !!}

    <div class="t" style="left:71.18pt;top:208.8pt">2.</div>
    <div class="t" style="left:93.62pt;top:208.8pt">No. of Sessions Conducted per Day:</div>
    {!! $box(287.0, 207.1, 305.8, 220.8, $is('sessions_per_day', 1)) !!}
    <div class="t" style="left:310.99pt;top:208.8pt">1</div>
    {!! $box(327.2, 207.1, 346.2, 220.8, $is('sessions_per_day', 2)) !!}
    <div class="t" style="left:351.31pt;top:208.8pt">2</div>
    {!! $box(367.5, 207.1, 386.5, 220.8, $is('sessions_per_day', 3)) !!}
    <div class="t" style="left:391.63pt;top:208.8pt">3</div>
    {!! $box(407.8, 207.1, 426.8, 220.8, $is('sessions_per_day', 4)) !!}
    <div class="t" style="left:431.98pt;top:208.8pt">4</div>

    <div class="t" style="left:71.18pt;top:247.8pt">3.</div>
    <div class="t" style="left:93.74pt;top:247.8pt">No. of Hour/s per session:</div>
    {!! $box(228.4, 246.1, 246.9, 260.1, $is('hours_per_session', '1')) !!}
    <div class="t" style="left:252.05pt;top:247.8pt">1 hr.</div>
    {!! $box(280.6, 246.1, 296.4, 260.1, $is('hours_per_session', '2')) !!}
    <div class="t" style="left:301.63pt;top:247.8pt">2 hrs.</div>
    {!! $box(345.4, 246.1, 363.9, 260.1, $is('hours_per_session', '2.5')) !!}
    <div class="t" style="left:369.07pt;top:247.8pt">2 &frac12;</div>
    {!! $box(397.1, 246.1, 414.9, 260.1, $is('hours_per_session', '3')) !!}
    <div class="t" style="left:420.1pt;top:247.8pt">3</div>

    <div class="t" style="left:72.02pt;top:287.07pt">4.</div>
    <div class="t" style="left:93.62pt;top:287.07pt">Age of Children Being Handled:</div>
    {!! $box(269.0, 285.4, 287.6, 299.1, $has('children_ages', '0')) !!}
    <div class="t" style="left:292.73pt;top:287.07pt">Below 1 y/o</div>
    {!! $box(269.0, 298.6, 287.6, 312.2, $has('children_ages', '1')) !!}
    <div class="t" style="left:292.73pt;top:300.27pt">1 year old</div>
    {!! $box(269.0, 311.7, 287.6, 325.4, $has('children_ages', '2')) !!}
    <div class="t" style="left:292.73pt;top:313.47pt">2 years old</div>
    {!! $box(269.0, 324.9, 287.6, 338.4, $has('children_ages', '3')) !!}
    <div class="t" style="left:292.73pt;top:326.55pt">3 years old</div>
    {!! $box(269.0, 338.0, 287.6, 351.6, $has('children_ages', '4')) !!}
    <div class="t" style="left:292.73pt;top:339.75pt">4 years old</div>
    {!! $rule(380.6, 285.9, 381.1, 351.2) !!}

    <div class="t" style="left:71.18pt;top:378.43pt;font-size:9.96pt">5.</div>
    <div class="t" style="left:93.74pt;top:377.55pt">No. of Hours staying in the Center:</div>
    {!! $box(269.0, 375.8, 287.4, 389.4, $is('hours_in_center', '1-2')) !!}
    <div class="t" style="left:292.61pt;top:377.55pt">1-2&nbsp; hrs</div>
    <div class="t" style="left:330.07pt;top:378.43pt;font-size:9.96pt">.</div>
    {!! $box(350.0, 375.8, 369.3, 389.4, $is('hours_in_center', '2.5-3')) !!}
    <div class="t" style="left:374.47pt;top:377.55pt">2 &frac12; - 3 hrs.</div>
    {!! $box(440.0, 375.8, 459.3, 389.4, $is('hours_in_center', '4-5')) !!}
    <div class="t" style="left:464.5pt;top:377.55pt">4-5 hrs.</div>
    {!! $box(269.0, 401.0, 287.4, 414.6, $is('hours_in_center', '6-7')) !!}
    <div class="t" style="left:292.61pt;top:402.63pt">6-7&nbsp; hrs</div>
    <div class="t" style="left:330.07pt;top:403.51pt;font-size:9.96pt">.</div>
    {!! $box(350.0, 401.0, 369.3, 414.6, $is('hours_in_center', '8')) !!}
    <div class="t" style="left:374.47pt;top:402.63pt">8 hours</div>

    <div class="t" style="left:71.18pt;top:439.35pt">6.</div>
    <div class="t" style="left:93.74pt;top:439.35pt">How sessions are conducted:</div>
    {!! $box(255.4, 437.6, 273.9, 451.2, $is('session_method', 'With reference materials')) !!}
    <div class="t" style="left:279.05pt;top:439.35pt">With reference materials</div>
    {!! $box(255.4, 450.8, 273.9, 464.5, $is('session_method', 'Without reference materials')) !!}
    <div class="t" style="left:279.05pt;top:452.45pt">Without reference materials</div>

    <div class="t" style="left:71.18pt;top:490.97pt">Name in Print</div>
    <div class="t" style="left:201.65pt;top:490.97pt">Signature</div>
    <div class="t" style="left:71.18pt;top:541.49pt">CDW:_______________________________</div>
    {!! $val(102.5, 550.1, 187, $w->full_name) !!}
    <div class="t" style="left:318.91pt;top:541.49pt">_______________________</div>

    <div class="t" style="left:71.18pt;top:630.05pt">Date Conducted: ______________________</div>
    {!! $val(158.8, 638.7, 132, $date($w->date_conducted, 'F d, Y')) !!}

    {!! $hline(54.8, 536.2, 704.8, 0.75) !!}

    <div class="t t-times" style="left:57.6pt;top:803.72pt">April 2014</div>
    <div class="t t-times" style="left:479.74pt;top:803.72pt">Page 3&nbsp; of&nbsp; 3</div>
</div>
</body>
</html>
