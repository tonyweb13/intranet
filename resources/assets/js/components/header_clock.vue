<template>
        <div id="hd_clockdate">
            <div class="clockdate-wrapper">
                <div class="clock" v-html="time_ticker"></div>
                <div class="date" v-html="date_now"></div>
                <!-- <view-button :to="{ name: 'payment-show', params: {payment_id: ''}}" /> -->
            </div>
        </div>

</template>
<style>
#hd_clockdate {
       font-family:arial,sans-serif;
    color: #333;
    text-align: center;
    bottom: -10;
    left: 0;
    padding: 10px 20px;
    position: absolute;
    right: 0;

}
#hd_clockdate .clock{
    font-weight: bolder;
    /* font-family: sans-serif; */
    font-size:18px;
    text-shadow:0px 0px 1px #fff;
}
#hd_clockdate .clock span {
    /* text-shadow:0px 0px 1px #333; */
    position:relative;
    font-size: 12px;
    top:-5px; 
    left:0px; 
}

#hd_clockdate .clock  label {
    position: relative;
    color:#1ab394;
    font-weight: 100;
}

#hd_clockdate .date {
    font-size:12px;
    position: relative;
    top: -10px;
    font-family:arial,sans-serif;
}
.navbar-header {
    z-index: 9999999;
}

@media (max-width: 576px) {

    #hd_clockdate {
        left: 0;
        padding: 10px 0px 0px 0px;
        position: relative;
        right: 0;
    }

}
</style>
<script>
    import ViewButton from '../shared/buttons/viewButton.vue'

    export default {
        components:{ ViewButton, },

        mounted() {
               this.tickTime();
        },

        beforeDestroy () {
                  clearInterval(this.intervalid1)
        },

	    data () {
			return { 
                time_ticker : this.currentTimeTicker(),
                date_now : this.dateNow(),
                work_week : this.workWeek(),
			}
        },
        
        methods: {
                currentTimeTicker : function () {

                            var today = new Date();
                            var hr = today.getHours();
                            var min = today.getMinutes();
                            var sec = today.getSeconds();
                            var ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
                            var hr = (hr == 0) ? 12 : hr;
                            var hr = (hr > 12) ? hr - 12 : hr;
                            //Add a zero in front of numbers<10
                            hr = this.checkTime(hr);
                            min = this.checkTime(min);
                            sec = this.checkTime(sec);

                    return "<label>WW"+this.workWeek()+"</label>  " + hr + ":" + min + ":" + sec + " " + ap;
                },

                workWeek : function () {
                    var today = new Date();
                    var date = new Date(today);
                    date.setHours(0, 0, 0, 0);
                    date.setDate(date.getDate() + 3 - (date.getDay() + 6) % 7);
                    var week1 = new Date(date.getFullYear(), 0, 4);
                    return 1 + Math.round(((date.getTime() - week1.getTime()) / 86400000 - 3 + (week1.getDay() + 6) % 7) / 7);
                },

                dateNow : function () {
                            var today = new Date();
                            var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                            var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                            var curWeekDay = days[today.getDay()];
                            var curDay = today.getDate();
                            var curMonth = months[today.getMonth()];
                            var curYear = today.getFullYear();
                            var date = curWeekDay+", "+curDay+" "+curMonth+" "+curYear;

                    return date;
                },

                tickTime : function(){         
                     window.setInterval(() => {
                                    this.time_ticker = this.currentTimeTicker();
                                    this.date_now = this.dateNow();
                      },500);
                },

                checkTime : function (i) {

                            if (i < 10) {
                                i = "0" + i;
                            }

                        return i;
                }

        }
        
    }
</script>