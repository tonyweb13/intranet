<template>
    <div>
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#SOF">SOF</a></li>
                <li class=""><a data-toggle="tab" href="#INBX">INBX</a></li>
                <li class=""><a data-toggle="tab" href="#COMET">COMET</a></li>
            </ul>
            <div class="tab-content">
                <div id="SOF" class="tab-pane active">
                     <portfolio :portfolioProps = "3" />
                </div>
                <div class="clearfix"></div>

                <div id="INBX" class="tab-pane">
                     <portfolio :portfolioProps = "4" />
                </div>
                <div class="clearfix"></div>

                <div id="COMET" class="tab-pane">
                     <portfolio :portfolioProps = "5" />
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</template>
<script>
    import portfolio from '../../../components/settings/users_groups/portfolio'

    export default {
        components: { portfolio },
    };
</script>