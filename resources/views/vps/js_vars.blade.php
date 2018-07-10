<script>
    if (typeof vps === 'undefined') { vps = {};}
    vps.csrf_token = '{{ csrf_token() }}';
    vps.settings = JSON.parse('{!! \App\Http\VpsVars::getVpsJSON() !!}');
    if (typeof window.Laravel === 'undefined') {
        window.Laravel = {};
    }
    window.Laravel.csrfToken = vps.csrf_token;
    window.vps = vps;
</script>
