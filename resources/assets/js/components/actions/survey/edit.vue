<template>
    <div class="ibox-content">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-settings" aria-expanded="true"> Settings</a></li>
                <li class=""><a data-toggle="tab" href="#tab-questions" aria-expanded="false">Questions</a></li>
            </ul>
            <div class="tab-content">
                <div class="clearfix"></div>
                <div id="tab-settings" class="tab-pane active">
                    <settings/>
                </div>
                <div class="clearfix"></div>
                    <div id="tab-questions" class="tab-pane">
                        <questions/>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</template>
<script>
    import settings from './settings.vue'
    import questions from './questions/questions.vue'

    export default {
        components: { settings, questions },
        
    }
</script>