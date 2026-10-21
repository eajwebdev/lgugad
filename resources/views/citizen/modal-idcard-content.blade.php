<style>
#table-card {
    width: 73%;
    border-collapse: collapse;
}

#table-card th, #table-card td {
    padding: 0px !important;
    margin: 0px !important;
    font-size: 12px !important;
}

#table-card tbody{
    padding: 0px !important;
}

.tr1{
    margin: -10px;
}

.bbot{
    text-decoration: underline;
}

</style>
<div class="colortable" style="width: 85.60mm; height: 53.98mm; border: 1px solid #000; border-radius: 5px;">
    <img src="{{ asset('uploads/senior-header.png') }}" class="seniorlogo">
    <div>
        <label class="pl-3 pt-3" style="font-size: 12px">Name:</label>
        <span style="font-size: 12px; text-decoration: underline;">
            {{ ucwords(strtolower($citizen->fname)) }}
            {{ ucwords(strtolower($citizen->mname)) }}
            {{ ucwords(strtolower($citizen->lname)) }}
        </span>
        <div class="square float-right">
            <img src="{{ !empty($citizen->profile) && is_file(public_path($citizen->profile)) ? asset($citizen->profile) : ($citizenI->gender == 'Female' ? asset('uploads/female-profile.png') : asset('uploads/male-profile.png')) }}"
            class="image-preview"
            width="100%" height="100%" 
            alt="Profile Image">
        </div>
    </div>
    <div class="addText">
        <p style="font-size: 12px; padding-left: 16px; text-decoration: underline;">
            <span style="font-weight: bold; ">Address:</span>
            @php
                $housePurok = isset($citizen->house_purok) ? ucwords(strtolower($citizen->house_purok)) . ', ' : '';
                $brgyName = $citizen->brgy ? $citizen->brgy . ', ' : '';
                $cityName = $citizen->city_mun ? $citizen->city_mun . ', ' : '';
                $provinceName = $citizen->province ?: '';
            @endphp
            <span>{{ $housePurok }} {{ $brgyName }} {{ $cityName }} {{ $provinceName }}</span>
        </p>               
    </div>
    <div class="birthText">
        <table id="table-card" style="margin-top: -15px;">
            <thead>
                <th class="text-center bbot" style=" width: 100px;">{{ $citizen->birth_date_label }}</th>
                <th class="text-center bbot" style="">{{ $citizen->gender }}</th>
                <th class="text-center bbot" style="">{{ $citizen->current_age ?? '—' }}</th>
            </thead>
            <tbody>
                <tr class="tr1">
                    <td class="text-center" style=" width: 100px;"><span id="span1">Date of Birth</span></td>
                    <td class="text-center" style=""><span id="span1">Sex</span></td>
                    <td class="text-center" style=""><span id="span1">Age</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="idcardLabel">
        <span class="pl-3" style="font-size: 10pt; font-weight: bold; margin-left: 160px !important">ID CARD NO. <b class="idnumber">{{ $citizen->osca_idnum  }}</b></span>
    </div>
    <div class="ml-1">
        <span class="pl-3" style="font-size: 8pt; font-style: italic;"><u>_______________________</u></span>
        <span class="" style="font-size: 8pt; font-weight: bold;">Date Issued:</span>
        <span class="" style="font-size: 8pt; font-weight: bold; text-decoration: underline;">May 16, 2023</span>
    </div>
    <div class="signatureLabel ml-1">
        <span class="pl-4" style="font-size: 8pt; font-style: italic;">Signature/Thumbmark</span>
    </div>
    <div class="validLabel ml-1 text-center">
        <span class="" style="font-size: 8pt; color: red">VALID ANYWHERE IN THE COUNTRY</span>
    </div>
</div>

<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>

<div class="colortable" style="width: 85.60mm; height: 53.98mm; border: 1px solid #000; border-radius: 5px;">
    <div>
        <label class="pl-2" style="font-size: 7pt; font-style: italic;">Benefits and Priviliges under Republic Act No. 9994</label>
    </div>
    <div style="margin-top:-18px !important">
        <span class="pl-2" style="font-size: 6.5pt;">- Free medical and dental, diagnostic & laboratory services in all government facilities.</span>
    </div>
    <div style="margin-top:-10px !important">
        <span class="pl-2" style="font-size: 6.5pt;">- 20% discount for medicines (Generic, Branded & Over the counter Medicines).</span>
    </div>
    <div style="margin-top:-10px !important">
        <span class="pl-2" style="font-size: 6.5pt;">- 20% discount in hotels, restaurants, recreation centers, etc.</span>
    </div>
    <div style="margin-top:-10px !important">
        <span class="pl-2" style="font-size: 6.5pt;">- 20% discount on theaters, cinema houses and concert halls, etc.</span>
    </div>
    <div style="margin-top:-10px !important">
        <span class="pl-2" style="font-size: 6.5pt;">- 20% discount on medical & dental services, diagnostic & laboratory fees in private</span>
    </div>
    <div style="margin-top:-10px !important">
        <span class="pl-3" style="font-size: 6.5pt;">facilities.</span>
    </div>
    <div style="margin-top:-10px !important">
        <span class="pl-2" style="font-size: 6.5pt;">- 20% discount in fare for domestic air, sea travel and public land transportation.</span>
    </div>
    <div style="margin-top:-10px !important">
        <span class="pl-2" style="font-size: 6.5pt;">- 5% discount in basic necessities and prime commodities.</span>
    </div>
    <div style="margin-top:-10px !important">
        <span class="pl-2" style="font-size: 6.5pt;">- 12% VAT exemption on the purchase of goods & services which are entitled to the</span>
    </div>
    <div style="margin-top:-10px !important">
        <span class="pl-3" style="font-size: 6.5pt;">20% discount</span>
    </div>
    <div style="margin-top:-10px !important">
        <span class="pl-2" style="font-size: 6.5pt;">- 5% discount on MAX 100kwh electric & 30 m3 water consumption</span>
    </div>
    <div style="margin-top:-10px !important">
        <center><span class="" style="font-size: 6.5pt;">Only for the exclusive use of Senior Citizen</span></center>
    </div>
    <div style="margin-top:-10px !important">
        <center><span class="" style="font-size: 6.5pt;">Abuse of priviliges is punishable by Law</span></center>
    </div>
    <div style="margin-top:-10px !important">
        <center><span class="" style="font-size: 6.5pt; font-weight: bold;">Person & Corporations violating RA 9994 shall be punished</span></center>
    </div>
    <div class="signatureBackLabel ml-1 text-center">
        {{-- <img src="{{ asset('template/img/mayorsign.png') }}" class="mayorsign"> --}}
        <span class="pl-2" style="font-size: 8pt; font-weight: bold;">HON. LEONARDO R. AVILLA III        </span>
        <span class="" style="font-size: 8pt; font-weight: bold; margin-left: 43px !important;">HON. ERNIE T. UY.</span>
    </div>
    <div class="ml-1 text-center" style="margin-top: -12px">
        <span class="pl-4" style="font-size: 6pt; margin-left: 20px !important;"><b>OSCA Head</b></span>
        <span class="pl-4" style="font-size: 6pt; margin-left: 75px !important;"><b>Municipal Mayor</b></span>
    </div>
</div>

<script>
    function triggerDownload(link) {
        const event = new MouseEvent('click', {
            view: window,
            bubbles: true,
            cancelable: true
        });
        link.dispatchEvent(event);
    }
    
    let downloadInProgress = false;

    $('#downloadStickerButton').click(function() {
        if (downloadInProgress) {
            return;
        }

        var id = $(this).val();
        const colortables = document.querySelectorAll('.colortable');

        colortables.forEach((colortable, index) => {
            const contentToCapture = colortable;
            const originalBackgroundColor = window.getComputedStyle(contentToCapture).backgroundColor;
            const backgroundColor = originalBackgroundColor;

            contentToCapture.style.backgroundColor = backgroundColor;

            const downloadLink = document.createElement('a');

            let downloadCanceled = false;

            html2canvas(contentToCapture).then(function(canvas) {
                if (downloadCanceled) {
                    contentToCapture.style.backgroundColor = originalBackgroundColor;
                    return;
                }

                const imageData = canvas.toDataURL('image/png');
                contentToCapture.style.backgroundColor = originalBackgroundColor;

                downloadLink.href = imageData;
                downloadLink.download = 'sticker_' + (index + 1) + '.png';
                downloadLink.setAttribute('data-cache-control', 'no-cache');

                triggerDownload(downloadLink);

                downloadInProgress = false;
            });
        });
        downloadInProgress = true;
    });
</script>
