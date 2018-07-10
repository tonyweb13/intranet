<template>   
<div id="shiftTimeline">
   
        <div id="vertical-timeline" class="vertical-container dark-timeline center-orientation">
                            <div class="vertical-timeline-block ">
                                <span class="vline navy-bg"></span>
                                <div class="vertical-timeline-icon navy-bg">
                                    <i class="fa fa-briefcase"></i>
                                </div>

                                <div class="vertical-timeline-content ">
                                    <h2>Shift Started</h2>
                                    <span class="vertical-date">
                                        Time <br> <small>11:00 AM</small>
                                    </span>
                                   
                                </div>
                            </div>

                            <div class="vertical-timeline-block">
                                 <span class="vline blue-bg"></span>
                                <div class="vertical-timeline-icon blue-bg">
                                    <i class="fa fa-file-text"></i>
                                </div>

                                <div class="vertical-timeline-content">
                                    <h2>Send documents to Mike</h2>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
                               
                                    <span class="vertical-date">
                                        Today <br>
                                        <small>Dec 24</small>
                                    </span>
                                </div>
                            </div>

                            <div class="vertical-timeline-block">
                                <span class="vline lazur-bg"></span>
                                <div class="vertical-timeline-icon lazur-bg">
                                    <i class="fa fa-coffee"></i>
                                </div>

                                <div class="vertical-timeline-content">
                                    <h2>Coffee Break</h2>
                                    <p>Go to shop and find some products. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's. </p>
                                </div>
                            </div>

                            <div class="vertical-timeline-block">
                                <span class="vline yellow-bg"></span>
                                <div class="vertical-timeline-icon yellow-bg">
                                    <i class="fa fa-phone"></i>
                                </div>

                                <div class="vertical-timeline-content">
                                    <h2>Phone with Jeronimo</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut.</p>
                                   
                                </div>
                            </div>

                            <div class="vertical-timeline-block">
                                 <span class="vline lazur-bg"></span>
                                <div class="vertical-timeline-icon lazur-bg">
                                    <i class="fa fa-user-md"></i>
                                </div>

                                <div class="vertical-timeline-content">
                                    <h2>Go to the doctor dr Smith</h2>
                                    <p>Find some issue and go to doctor. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. </p>
                                   
                                </div>
                            </div>

                            <div class="vertical-timeline-block">
                                <div class="vertical-timeline-icon red-bg">
                                    <i class="fa fa-comments"></i>
                                </div>

                                <div class="vertical-timeline-content">
                                    <h2>End Shift</h2>
                                       <span class="vertical-date">
                                        Time <br>
                                        <small>6:00 AM</small>
                                    </span>
                                </div>
                            </div>
                        </div>
                       
</div>

<!-- 
    <div id="shiftTimeline">
           <h3>Click start shift button to start your shift</h3>
        <div class="box">
            <div class="vtl-line">
                <div class="vertical-timeline-icon navy-bg vtline-graph">
                    <span class="vline"></span>
                                        <i class="fa fa-briefcase"></i>
                </div>
                <div class="vertical-timeline-icon navy-bg vtline-graph">
                    <span class="vline"></span>
                                        <i class="fa fa-briefcase"></i>
                </div>
                <div class="line start"></div>
                <div class="line end"></div>
            </div>
         
            <button type="button" class="btn btn-w-m btn-primary"><i class="fa fa-clock-o"></i> Start Shift</button>
      
        </div>
    </div> -->
</template>
<style>
#shiftTimeline  .vertical-timeline-icon {
    z-index: 999;
}
#shiftTimeline  .vline{
    position: absolute;
    top:30%;
    left: 50%;
    height: 100%;
    margin-left: -2px;
    width: 4px;
    z-index: 1;
}

#shiftTimeline .center-orientation .vertical-timeline-block {
    margin: 20px 0;
}


@media (max-width:1150px) { 

    #shiftTimeline  .vline{
        position: absolute;
        top:30%;
        left: 50%;
        height: 100%;
        margin-left: -2px;
        width: 4px;
        z-index: 1;
        display: none !important;
    }

}
</style>

<script>
    import axios from 'axios'
    
    export default {
         
    }
</script>
