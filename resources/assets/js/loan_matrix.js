/**
 * Created by Tony on 02/20/2018
 */

$("#addBalance1").click(function(){
    $("#addBalance1").hide();
    $("#DD1").css({"width":'255%'});
    $("#DD2").val("");
    $("#balance2").show();
    $("#removeBalance2").show();
    if($('#balance3').css('display') == 'none')
    {
        $("#addBalance2").show();
    }
});

$("#addBalance2").click(function(){
    $("#addBalance2").hide();
    $("#DD3").val("");
    $("#balance3").show();
    $("#removeBalance3").show();
    if($('#balance4').css('display') == 'none')
    {
        $("#addBalance3").show();
    }
});
$("#removeBalance2").click(function(){
    $("#balance2").hide();
    $("#DD1").removeAttr('style');
    $("#DD2").val("");
    $("#addBalance1").show();
});

$("#addBalance3").click(function(){
    $("#addBalance3").hide();
    $("#DD4").val("");
    $("#balance4").show();
    $("#removeBalance4").show();
    if($('#balance5').css('display') == 'none')
    {
        $("#addBalance4").show();
    }

});
$("#removeBalance3").click(function(){
    $("#balance3").hide();
    $("#DD3").val("");
    $("#addBalance2").show();
});

$("#addBalance4").click(function(){
    $("#addBalance4").hide();
    $("#balance5").show();
    $("#DD5").val("");
    $("#removeBalance5").show();
    if($('#balance6').css('display') == 'none')
    {
        $("#addBalance5").show();
    }
});
$("#removeBalance4").click(function(){
    $("#balance4").hide();
    $("#DD4").val("");
    $("#addBalance3").show();
});

$("#addBalance5").click(function(){
    $("#balance6").show();
    $("#DD6").val("");
    $("#removeBalance6").show();
    $("#addBalance5").hide();
});
$("#removeBalance5").click(function(){
    $("#balance5").hide();
    $("#DD5").val("");
    $("#addBalance4").show();
});

$("#removeBalance6").click(function(){
    $("#balance6").hide();
    $("#DD6").val("");
    $("#addBalance5").show();
});

$("#matrixClear").click(function() {
    $('#Port, #annualInterestRate, #numberOfYears, #loanAmount, #loan, #DL, #EXP, #na, #monthlyPayment').val('');
    $("#portfolioRequired").hide();
});

$("#loanmatrixform input[type='number']").keydown(function (e) {
    // Allow){ backspace, delete, tab, escape, enter && .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
        // Allow){ Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) ||
        // Allow){ Ctrl+C
        (e.keyCode == 67 && e.ctrlKey === true) ||
        // Allow){ Ctrl+X
        (e.keyCode == 88 && e.ctrlKey === true) ||
        // Allow){ home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
        // let it happen, don't do anything
        return;
    }
    // Ensure that it is a number && stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});

$("#Port").change(function() {
    if($("#Port").val() == "INBX" || $("#Port").val() == "SOF") {
        $("#showInbox").show();

        $("#balance2").hide();
        $("#balance3").hide();
        $("#balance4").hide();
        $("#balance5").hide();
        $("#balance6").hide();
    }else{
        $("#showInbox").hide();
    }
});

$("#matrixResult").click(function() {
    var loan = $("#loan").val();
    var Port = $("#Port").val();
    var EXP = $("#EXP").val();
    var DL = $("#DL").val();
    var na = $("#na").val();
    var loanAmount = $("#loanAmount").val();
    var numberOfYears = $("#numberOfYears").val();
    var annualInterestRate = $("#annualInterestRate").val();

    //For Inbox only
    var PF  = $("#PF").val();
    var DD1 = $("#DD1").val();
    var DD2 = $("#DD2").val();
    var DD3 = $("#DD3").val();
    var DD4 = $("#DD4").val();
    var DD5 = $("#DD5").val();
    var DD6 = $("#DD6").val();

    if (annualInterestRate === null || annualInterestRate == ""){
        var annualInterestRate = 0;
    }
    if (loanAmount === null || loanAmount == ""){
        var loanAmount = 0;
    }
    if (na === null || na == ""){
        var na = 0;
    }

    if (Port == '') {
        $("#portfolioRequired").show();
    } else {
        $("#portfolioRequired").hide();
    }

    /*#=======NORP*/

    if (Port=='NPF'){
        if (loan == 0 && (annualInterestRate * 0.2 - loanAmount) >= 200 && (
                annualInterestRate * 0.3 - loanAmount) <= 700  && numberOfYears <= 3 && EXP == 1 && (
                annualInterestRate * 0.2 - loanAmount) / 2 >= Math.abs(na)){
            $("#monthlyPayment").val(Math.round((annualInterestRate * 0.2 - loanAmount), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if (loan == 0 && (
                annualInterestRate * 0.2 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 1  && EXP == 1 && numberOfYears <= 3 && (
                Math.min((annualInterestRate * 0.2 - loanAmount), 1000)) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.3 - loanAmount) > 700){
            $("#monthlyPayment").val(Math.round(Math.min((annualInterestRate * 0.2 - loanAmount), 1000), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if (loan == 0 && (
                annualInterestRate * 0.2 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 0 &&  EXP == 1 && numberOfYears <= 3 && (
                annualInterestRate * 0.3 - loanAmount) > 700 && (
                Math.min(Math.max((annualInterestRate * 0.2 - loanAmount), 200), 1000)) / 2 >= Math.abs(na)){
            $("#monthlyPayment").val(Math.round(Math.min(Math.max((annualInterestRate * 0.2 - loanAmount), 200), 1000), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if (loan == 0 && (annualInterestRate * 0.3 - loanAmount) >= 200 && (
                annualInterestRate * 0.3 - loanAmount) <= 700  && EXP == 0 && (
                annualInterestRate * 0.3 - loanAmount) / 2 >= Math.abs(na) && numberOfYears <= 3){
            $("#monthlyPayment").val(Math.round((annualInterestRate * 0.3 - loanAmount), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if (loan == 1 && (annualInterestRate * 0.35 - loanAmount) >= 200 && (
                annualInterestRate * 0.35 - loanAmount) <= 1100  && (
                annualInterestRate * 0.35 - loanAmount) / 2 >= Math.abs(na) && numberOfYears <= 3){
            $("#monthlyPayment").val(Math.round((annualInterestRate * 0.35 - loanAmount), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if (loan > 1 && (annualInterestRate * 0.40 - loanAmount) >= 200 && (
                annualInterestRate * 0.40 - loanAmount) <= 1100  && (
                annualInterestRate * 0.40 - loanAmount) / 2 >= Math.abs(na) && numberOfYears <= 3){
            $("#monthlyPayment").val(Math.round((annualInterestRate * 0.40 - loanAmount), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if (loan == 0 && (
                annualInterestRate * 0.3 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 1  && EXP == 0 && (
                Math.min((annualInterestRate * 0.3 - loanAmount), 1000)) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.3 - loanAmount) > 700){
            $("#monthlyPayment").val(Math.round(Math.min((annualInterestRate * 0.3 - loanAmount), 1000), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if (loan == 0 && (
                annualInterestRate * 0.3 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 0 && EXP == 0 && (
                Math.min(Math.max((annualInterestRate * 0.2 - loanAmount), 700), 1000)) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.3 - loanAmount) > 700){
            $("#monthlyPayment").val(Math.round(Math.min(Math.max((annualInterestRate * 0.2 - loanAmount), 700), 1000), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if (loan == 1 && (
                annualInterestRate * 0.35 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 1  && (
                Math.min(Math.max(annualInterestRate * 0.35 - loanAmount, 200), 2500)) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.35 - loanAmount) >= 1100){
            $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.35 - loanAmount, 200), 2500), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if (loan == 1 && (
                annualInterestRate * 0.35 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 0  && (
                Math.min(Math.max(annualInterestRate * 0.25 - loanAmount, 1100), 2500)) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.35 - loanAmount) >= 1100){
            $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.25 - loanAmount, 1100), 2500), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if (loan > 1 && (
                annualInterestRate * 0.40 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 1  && (
                Math.min(Math.max(annualInterestRate * 0.40 - loanAmount, 200), 2500)) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.40 - loanAmount) >= 1100){
            $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.40 - loanAmount, 200), 2500), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if (loan > 1 && (
                annualInterestRate * 0.40 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 0  && Math.min(
                Math.max(annualInterestRate * 0.30 - loanAmount, 1100), 2500) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.40 - loanAmount) >= 1100) {
            $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.30 - loanAmount, 1100), 2500), 2));
            $("#monthlyPayment").css({color: "green"});

        } else {
            $("#monthlyPayment").val('Not Qualify');
            $("#monthlyPayment").css({color: "red"});
        }

    } else if (Port=='SLS'){
        if ((loan == 0 && (annualInterestRate * 0.2 - loanAmount) >= 300 && (annualInterestRate * 0.3 - loanAmount) <= 700  && EXP == 1
                && (annualInterestRate * 0.2 - loanAmount) / 2 > Math.abs(na) && numberOfYears <= 3)){
            $("#monthlyPayment").val(Math.round((annualInterestRate * 0.2 - loanAmount), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if( (loan == 0 && (
                annualInterestRate * 0.2 - loanAmount) >= 300 && numberOfYears <= 3 && DL == 1 && EXP == 1 && Math.min(
                (annualInterestRate * 0.2 - loanAmount), 1500) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.3 - loanAmount) > 700)){
            $("#monthlyPayment").val(Math.round(Math.min((annualInterestRate * 0.2 - loanAmount), 1500), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if( (loan == 0 && (
                annualInterestRate * 0.2 - loanAmount) >= 300 && numberOfYears <= 3 && DL == 0  && EXP == 1 && Math.min(
                Math.max((annualInterestRate * 0.2 - loanAmount), 300), 1500) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.3 - loanAmount) > 700)){
            $("#monthlyPayment").val(Math.round(Math.min(Math.max((annualInterestRate * 0.2 - loanAmount), 300), 1500), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if( (loan == 0 && (annualInterestRate * 0.3 - loanAmount) >= 300 && (
                annualInterestRate * 0.3 - loanAmount) <= 700 && EXP == 0 && (
                annualInterestRate * 0.3 - loanAmount) / 2 >= Math.abs(na) && numberOfYears <= 3)){
            $("#monthlyPayment").val(Math.round((annualInterestRate * 0.3 - loanAmount), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if( (loan == 1 && (annualInterestRate * 0.35 - loanAmount) >= 300 && (
                annualInterestRate * 0.35 - loanAmount) <= 1100  && (
                annualInterestRate * 0.35 - loanAmount) / 2 >= Math.abs(na) && numberOfYears <= 3)){
            $("#monthlyPayment").val(Math.round((annualInterestRate * 0.35 - loanAmount), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if( (loan > 1 && (annualInterestRate * 0.40 - loanAmount) >= 300 && (
                annualInterestRate * 0.40 - loanAmount) <= 1100  && (
                annualInterestRate * 0.40 - loanAmount) / 2 >= Math.abs(na) && numberOfYears <= 3)){
            $("#monthlyPayment").val(Math.round((annualInterestRate * 0.40 - loanAmount), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if( (loan == 0 && (
                annualInterestRate * 0.3 - loanAmount) >= 300 && numberOfYears <= 3 && DL == 1  && EXP == 0 && Math.min(
                (annualInterestRate * 0.3 - loanAmount), 1500) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.3 - loanAmount) > 700)){
            $("#monthlyPayment").val(Math.round(Math.min((annualInterestRate * 0.3 - loanAmount), 1500), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if( (loan == 0 && (
                annualInterestRate * 0.3 - loanAmount) >= 300 && numberOfYears <= 3 && DL == 0 && EXP == 0 && Math.min(
                Math.max((annualInterestRate * 0.2 - loanAmount), 700), 1500) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.3 - loanAmount) > 700)){
            $("#monthlyPayment").val(Math.round(Math.min(Math.max((annualInterestRate * 0.2 - loanAmount), 700), 1500), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if( (loan == 1 && (
                annualInterestRate * 0.35 - loanAmount) >= 300 && numberOfYears <= 3 && DL == 1 && Math.min(
                annualInterestRate * 0.35 - loanAmount, 5000) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.35 - loanAmount) >= 1100)){
            $("#monthlyPayment").val(Math.round(Math.min(annualInterestRate * 0.35 - loanAmount, 5000), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if( (loan == 1 && (
                annualInterestRate * 0.35 - loanAmount) >= 300 && numberOfYears <= 3 && DL == 0  && Math.min(
                Math.max(annualInterestRate * 0.25 - loanAmount, 1100), 5000) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.35 - loanAmount) >= 1100)){
            $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.25 - loanAmount, 1100), 5000), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if( (loan > 1 && (
                annualInterestRate * 0.40 - loanAmount) >= 300 && numberOfYears <= 3 && DL == 1  && Math.min(
                annualInterestRate * 0.40 - loanAmount, 5000) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.40 - loanAmount) >= 1100)){
            $("#monthlyPayment").val(Math.round(Math.min(annualInterestRate * 0.40 - loanAmount, 5000), 2));
            $("#monthlyPayment").css({color: "green"});

        } else if( (loan > 1 && (
                annualInterestRate * 0.40 - loanAmount) >= 300 && numberOfYears <= 3 && DL == 0  && Math.min(
                Math.max(annualInterestRate * 0.30 - loanAmount, 1100), 5000) / 2 >= Math.abs(na) && (
                annualInterestRate * 0.40 - loanAmount) >= 1100)) {
            $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.30 - loanAmount, 1100), 5000), 2));
            $("#monthlyPayment").css({color: "green"});

        } else {
            $("#monthlyPayment").val('Not Qualify');
            $("#monthlyPayment").css({color: "red"});
        }
    } else if (Port=='INBX') {

        if (PF == '') {
            $("#FrequencyRequired").show();
        } else {
            $("#FrequencyRequired").hide();
        }

        if (DD1 == '0'){
            var DD1count = 1;
        }else if (DD1 === null || DD1 == ""){
            var DD1 = 0;
        }
        if (DD2 == '0'){
            var DD2count = 1;
        }else if (DD2 === null || DD2 == ""){
            var DD2 = 0;
        }
        if (DD3 == '0'){
            var DD3count = 1;
        }else if (DD3 === null || DD3 == ""){
            var DD3 = 0;
        }
        if (DD4 == '0'){
            var DD4count = 1;
        }else if (DD4 === null || DD4 == ""){
            var DD4 = 0;
        }
        if (DD5 == '0'){
            var DD5count = 1;
        }else if (DD5 === null || DD5 == ""){
            var DD5 = 0;
        }
        if (DD6 == '0'){
            var DD6count = 1;
        }else if (DD6 === null || DD6 == ""){
            var DD6 = 0;
        }

        if(DD1count == undefined){
            var DD1count = 0;
        }
        if(DD2count == undefined){
            var DD2count = 0;
        }
        if(DD3count == undefined){
            var DD3count = 0;
        }
        if(DD4count == undefined){
            var DD4count = 0;
        }
        if(DD5count == undefined){
            var DD5count = 0;
        }
        if(DD6count == undefined){
            var DD6count = 0;
        }

        var DDsum = parseInt(DD1count) + parseInt(DD2count) + parseInt(DD3count) + parseInt(DD4count) + parseInt(DD5count) + parseInt(DD6count); //if I enter zero value
        console.log("DDsum="+DDsum);

        var List = [DD1, DD2, DD3, DD4, DD5, DD6];
        var new_list = 0;
        var count = 0;

        for(var i=0; i <= 6; i++){
            if(Math.sign(List[i])){
                count++;
            }
        }

        var new_list = parseFloat(parseInt(DD1))+parseFloat(parseInt(DD2))+parseFloat(parseInt(DD3))+parseFloat(parseInt(DD4))+parseFloat(parseInt(DD5))+parseFloat(parseInt(DD6));

        if (count==0){
            var EndingB = 9000;
        }else{
            if(count > 1){

                if(DD1 == DD2 && DD1 == DD3 && DD1 == DD4 && DD1 == DD5 && DD1 == DD6) {
                    var exclude_max_list = [DD2, DD3, DD4, DD5, DD6];
                    console.log("exclude_max_list5="+exclude_max_list);

                }else if(DD1 == DD2 && DD1 == DD3 && DD1 == DD4 && DD1 == DD5 && (DD6 == null)) {
                    var exclude_max_list = [DD2, DD3, DD4, DD5];
                    console.log("exclude_max_list4="+exclude_max_list);

                }else if(DD1 == DD2 && DD1 == DD3 && DD1 == DD4 && (DD5 == null || DD6 == null)) {
                    var exclude_max_list = [DD2, DD3, DD4];
                    console.log("exclude_max_list3="+exclude_max_list);

                }else if(DD1 == DD2 && DD1 == DD3 && (DD4 == null || DD5 == null || DD6 == null)) {
                    var exclude_max_list = [DD2, DD3];
                    console.log("exclude_max_list2="+exclude_max_list);

                }else if(DD1 == DD2 && (DD3 == null || DD4 == null || DD5 == null || DD6 == null)) {
                    var exclude_max_list = [DD2];
                    console.log("exclude_max_list1="+exclude_max_list);

                }else{

                    var maxList = Math.max.apply(null, List); //get max in array

                    if(maxList == DD1 && (DD2 != null || DD3 != null || DD4 != null || DD5 != null || DD6 != null)) {
                        var exclude_max_list = [DD2, DD3, DD4, DD5, DD6];
                        console.log("exclude_max_list6=" + exclude_max_list + " max=" + maxList);

                    }else if(maxList == DD2 && (DD1 != null || DD3 != null || DD4 != null || DD5 != null || DD6 != null)){
                        var exclude_max_list = [DD1, DD3, DD4, DD5, DD6];
                        console.log("exclude_max_list7="+exclude_max_list+" max="+maxList);

                    }else if(maxList == DD3 && (DD1 != null || DD2 != null || DD4 != null || DD5 != null || DD6 != null)){
                        var exclude_max_list = [DD1, DD2, DD4, DD5, DD6];
                        console.log("exclude_max_list8="+exclude_max_list+" max="+maxList);

                    }else if(maxList == DD4 && (DD1 != null || DD2 != null || DD3 != null || DD5 != null || DD6 != null)){
                        var exclude_max_list = [DD1, DD2, DD3, DD5, DD6];
                        console.log("exclude_max_list9="+exclude_max_list+" max="+maxList);

                    }else if(maxList == DD5 && (DD1 != null || DD2 != null || DD3 != null || DD4 != null || DD6 != null)){
                        var exclude_max_list = [DD1, DD2, DD3, DD4, DD6];
                        console.log("exclude_max_list10="+exclude_max_list+" max="+maxList);

                    }else if(maxList == DD6 && (DD1 != null || DD2 != null || DD3 != null || DD4 != null || DD5 != null)){
                        var exclude_max_list = [DD1, DD2, DD3, DD4, DD5];
                        console.log("exclude_max_list11="+exclude_max_list+" max="+maxList);

                    }else{
                        var exclude_max_list = $.grep( List, function( n ) { //make it array the remaining List
                            return n != maxList;
                        });
                        console.log("exclude_max_list="+exclude_max_list+" max="+maxList);
                    }
                }

                var new_list = eval(exclude_max_list.join("+")); //sum the array

                var EndingB = parseFloat(parseInt(new_list)) / parseFloat(parseInt(count+DDsum-1));

                console.log("INBOX > 1 List="+List+" EndingB = "+parseFloat(parseInt(new_list))+" / "+parseFloat(parseInt(count+DDsum-1))+" == "+EndingB);

            } else {
                var new_list = parseFloat(parseInt(DD1))+parseFloat(parseInt(DD2))+parseFloat(parseInt(DD3))+parseFloat(parseInt(DD4))+parseFloat(parseInt(DD5))+parseFloat(parseInt(DD6));
                var EndingB = parseFloat(parseInt(new_list)) / parseFloat(parseInt(count+DDsum));
                console.log("INBOX List="+List+" new_list="+new_list+" EndingB = "+EndingB);
            }
        }
        console.log("INBOX DD1count="+DD1count+" DD2count="+DD2count+" DD3count="+DD3count+" DD4count="+DD4count+" DD5count="+DD5count+" DD6count="+DD6count+" DDsum="+DDsum+" count="+count);

        if (PF == 'W' && (EndingB / 1.5 / 0.15) >= 200) {
            var AAA = EndingB / 1.5 / 0.15;

        } else if ((PF == 'B' || PF == 'S') && (EndingB / 1.5 / 0.3) >= 200) {
            var AAA = EndingB / 1.5 / 0.3;

        } else {
            var AAA = EndingB / 1.5 / 0.3;
            $("#monthlyPayment").val('Not Qualify');
            $("#monthlyPayment").css({color: "red"});
        }

        if (numberOfYears <= 3) {

            if (loan == 0 && EXP == 1) {

                if (DL == 0 && (annualInterestRate * 0.22 - loanAmount) >= 200 && Math.min((annualInterestRate * 0.22 - loanAmount), Math.round((AAA - loanAmount), 2), 1000) / 2 >= Math.abs(na)) {
                    $("#monthlyPayment").val(Math.min(Math.round(Math.min(Math.max((annualInterestRate * 0.22 - loanAmount), 200), 1000), 2), Math.round((AAA - loanAmount), 2)));
                    $("#monthlyPayment").css({color: "green"});

                } else if ((  DL == 1 && (annualInterestRate * 0.32 - loanAmount) >= 200 && Math.min((annualInterestRate * 0.22 - loanAmount), Math.round((AAA - loanAmount), 2), 1500) / 2 >= Math.abs(na))) {
                    $("#monthlyPayment").val(Math.min(Math.round(Math.min(Math.max((annualInterestRate * 0.22 - loanAmount), 200), 1500), 2), Math.round((AAA - loanAmount), 2)));
                    $("#monthlyPayment").css({color: "green"});

                } else {
                    $("#monthlyPayment").val('Not Qualify');
                    $("#monthlyPayment").css({color: "red"});
                }

            } else if (loan == 0 && EXP == 0) {

                if (DL == 0 && (annualInterestRate * 0.32 - loanAmount) >= 700 && Math.min((annualInterestRate * 0.32 - loanAmount), Math.round((AAA - loanAmount), 2), 1000) / 2 >= Math.abs(na)) {
                    $("#monthlyPayment").val(Math.min(Math.round(Math.min(Math.max((annualInterestRate * 0.22 - loanAmount), 700), 1000), 2), Math.round((AAA - loanAmount), 2)));
                    $("#monthlyPayment").css({color: "green"});

                } else if (DL == 0 && (annualInterestRate * 0.32 - loanAmount) < 700 && Math.min((annualInterestRate * 0.32 - loanAmount), Math.round((AAA - loanAmount), 2), 1000) / 2 >= Math.abs(na) && (annualInterestRate * 0.32 - loanAmount) >= 200) {
                    $("#monthlyPayment").val(Math.min(Math.round((annualInterestRate * 0.32 - loanAmount), 2), Math.round((AAA - loanAmount), 2)));
                    $("#monthlyPayment").css({color: "green"});

                } else if (DL == 1 && (annualInterestRate * 0.32 - loanAmount) >= 700 && Math.min((annualInterestRate * 0.32 - loanAmount), Math.round((AAA - loanAmount), 2), 1500) / 2 >= Math.abs(na)) {
                    $("#monthlyPayment").val(Math.min(Math.round(Math.min(Math.max((annualInterestRate * 0.32 - loanAmount), 700), 1500), 2), Math.round((AAA - loanAmount), 2)));
                    $("#monthlyPayment").css({color: "green"});

                } else if (DL == 1 && (annualInterestRate * 0.32 - loanAmount) < 700 && Math.min((annualInterestRate * 0.32 - loanAmount), Math.round((AAA - loanAmount), 2), 1500) / 2 >= Math.abs(na) && (annualInterestRate * 0.32- loanAmount) >= 200) {
                    $("#monthlyPayment").val(Math.min(Math.round((annualInterestRate * 0.32 - loanAmount), 2), Math.round((AAA - loanAmount), 2)));
                    $("#monthlyPayment").css({color: "green"});

                } else {
                    $("#monthlyPayment").val('Not Qualify');
                    $("#monthlyPayment").css({color: "red"});
                }

            } else if (loan == 1 && (
                    annualInterestRate * 0.37 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 1 && Port == 'INBX' && (
                    Math.min(Math.max(annualInterestRate * 0.37 - loanAmount, 200), 2500)) / 1.5 >= Math.abs(na) && (
                    annualInterestRate * 0.37 - loanAmount) >= 1100) {
                $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.37 - loanAmount, 200), 5000), 2));
                $("#monthlyPayment").css({color: "green"});

            } else if (loan == 1 && (
                    annualInterestRate * 0.37 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 0 && Port == 'INBX' && (
                    Math.min(Math.max(annualInterestRate * 0.25 - loanAmount, 1100), 5000)) / 1.5 >= Math.abs(na) && (
                    annualInterestRate * 0.37 - loanAmount) >= 1100) {
                $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.27 - loanAmount, 1100), 5000), 2));
                $("#monthlyPayment").css({color: "green"});

            } else if (loan > 1 && (
                    annualInterestRate * 0.42 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 1 && Port == 'INBX' && (
                    Math.min(Math.max(annualInterestRate * 0.42 - loanAmount, 200), 5000)) / 1.5 >= Math.abs(na) && (
                    annualInterestRate * 0.42 - loanAmount) >= 1100) {
                $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.42 - loanAmount, 200), 5000), 2));
                $("#monthlyPayment").css({color: "green"});

            } else if (loan > 1 && (
                    annualInterestRate * 0.42 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 0 && Port == 'INBX' && Math.min(
                    Math.max(annualInterestRate * 0.32 - loanAmount, 1100), 5000) / 1.5 >= Math.abs(na) && (
                    annualInterestRate * 0.42 - loanAmount) >= 1100) {
                $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.32 - loanAmount, 1100), 5000), 2));
                $("#monthlyPayment").css({color: "green"});

            } else if (loan == 1 && (annualInterestRate * 0.37 - loanAmount) >= 200 && (
                    annualInterestRate * 0.37 - loanAmount) <= 1100 && Port == 'INBX' && (
                    annualInterestRate * 0.37 - loanAmount) / 1.5 >= Math.abs(na) && numberOfYears <= 3) {
                $("#monthlyPayment").val(Math.round((annualInterestRate * 0.37 - loanAmount), 2));
                $("#monthlyPayment").css({color: "green"});

            } else if (loan > 1 && (annualInterestRate * 0.37 - loanAmount) >= 200 && (
                    annualInterestRate * 0.37 - loanAmount) <= 1100 && Port == 'INBX' && (
                    annualInterestRate * 0.37 - loanAmount) / 1.5 >= Math.abs(na) && numberOfYears <= 3) {
                $("#monthlyPayment").val(Math.round((annualInterestRate * 0.37 - loanAmount), 2));
                $("#monthlyPayment").css({color: "green"});

            } else {
                $("#monthlyPayment").val('Not Qualify');
                $("#monthlyPayment").css({color: "red"});
            }

        } else {
            $("#monthlyPayment").val('Not Qualify');
            $("#monthlyPayment").css({color: "red"});
        }

        if(AAA < 200){
            $("#monthlyPayment").val('Not Qualify');
            $("#monthlyPayment").css({color: "red"});
        }

        console.log("INBOX loan="+loan+" Port="+Port+" EXP="+EXP+" DL="+DL+" na="+na+" loanAmount="+loanAmount+" numberOfYears="+numberOfYears+" annualInterestRate="+annualInterestRate+" PF="+PF+
            " DD1="+DD1+" DD2="+DD2+" DD3="+DD3+" DD4="+DD4+" DD5="+DD5+" AAA="+AAA+" count="+count+" list="+List+" EndingB="+EndingB+ " new_list="+new_list+ " EndingB2 "+EndingB+ " = "+parseFloat(parseInt(new_list))+" / "+parseFloat(parseInt(count+DDsum))+" approved_amount1="+EndingB / 1.5 / 0.15+" approved_amount2="+EndingB / 1.5 / 0.3);

    } else if (Port=='SOF') {

        if (PF == '') {
            $("#FrequencyRequired").show();
        } else {
            $("#FrequencyRequired").hide();
        }

        if (DD1 == '0'){
            var DD1count = 1;
        }else if (DD1 === null || DD1 == ""){
            var DD1 = 0;
        }
        if (DD2 == '0'){
            var DD2count = 1;
        }else if (DD2 === null || DD2 == ""){
            var DD2 = 0;
        }
        if (DD3 == '0'){
            var DD3count = 1;
        }else if (DD3 === null || DD3 == ""){
            var DD3 = 0;
        }
        if (DD4 == '0'){
            var DD4count = 1;
        }else if (DD4 === null || DD4 == ""){
            var DD4 = 0;
        }
        if (DD5 == '0'){
            var DD5count = 1;
        }else if (DD5 === null || DD5 == ""){
            var DD5 = 0;
        }
        if (DD6 == '0'){
            var DD6count = 1;
        }else if (DD6 === null || DD6 == ""){
            var DD6 = 0;
        }

        if(DD1count == undefined){
            var DD1count = 0;
        }
        if(DD2count == undefined){
            var DD2count = 0;
        }
        if(DD3count == undefined){
            var DD3count = 0;
        }
        if(DD4count == undefined){
            var DD4count = 0;
        }
        if(DD5count == undefined){
            var DD5count = 0;
        }
        if(DD6count == undefined){
            var DD6count = 0;
        }

        var DDsum = parseInt(DD1count) + parseInt(DD2count) + parseInt(DD3count) + parseInt(DD4count) + parseInt(DD5count) + parseInt(DD6count); //if I enter zero value
        var List = [DD1, DD2, DD3, DD4, DD5, DD6];
        var new_list = 0;
        var count = 0;

        for(var i=0; i <= 6; i++){
            if(Math.sign(List[i])){
                count++;
            }
        }

        var new_list = parseFloat(parseInt(DD1))+parseFloat(parseInt(DD2))+parseFloat(parseInt(DD3))+parseFloat(parseInt(DD4))+parseFloat(parseInt(DD5))+parseFloat(parseInt(DD6));

        if (count==0){
            var EndingB = 9000;
        }else{

            if(count > 1){

                if(DD1 == DD2 && DD1 == DD3 && DD1 == DD4 && DD1 == DD5 && DD1 == DD6) {
                    var exclude_max_list = [DD2, DD3, DD4, DD5, DD6];
                    console.log("exclude_max_list5="+exclude_max_list);

                }else if(DD1 == DD2 && DD1 == DD3 && DD1 == DD4 && DD1 == DD5 && (DD6 == null)) {
                    var exclude_max_list = [DD2, DD3, DD4, DD5];
                    console.log("exclude_max_list4="+exclude_max_list);

                }else if(DD1 == DD2 && DD1 == DD3 && DD1 == DD4 && (DD5 == null || DD6 == null)) {
                    var exclude_max_list = [DD2, DD3, DD4];
                    console.log("exclude_max_list3="+exclude_max_list);

                }else if(DD1 == DD2 && DD1 == DD3 && (DD4 == null || DD5 == null || DD6 == null)) {
                    var exclude_max_list = [DD2, DD3];
                    console.log("exclude_max_list2="+exclude_max_list);

                }else if(DD1 == DD2 && (DD3 == null || DD4 == null || DD5 == null || DD6 == null)) {
                    var exclude_max_list = [DD2];
                    console.log("exclude_max_list1="+exclude_max_list);

                }else{

                    var maxList = Math.max.apply(null, List); //get max in array

                    if(maxList == DD1 && (DD2 != null || DD3 != null || DD4 != null || DD5 != null || DD6 != null)) {
                        var exclude_max_list = [DD2, DD3, DD4, DD5, DD6];
                        console.log("exclude_max_list6=" + exclude_max_list + " max=" + maxList);

                    }else if(maxList == DD2 && (DD1 != null || DD3 != null || DD4 != null || DD5 != null || DD6 != null)){
                        var exclude_max_list = [DD1, DD3, DD4, DD5, DD6];
                        console.log("exclude_max_list7="+exclude_max_list+" max="+maxList);

                    }else if(maxList == DD3 && (DD1 != null || DD2 != null || DD4 != null || DD5 != null || DD6 != null)){
                        var exclude_max_list = [DD1, DD2, DD4, DD5, DD6];
                        console.log("exclude_max_list8="+exclude_max_list+" max="+maxList);

                    }else if(maxList == DD4 && (DD1 != null || DD2 != null || DD3 != null || DD5 != null || DD6 != null)){
                        var exclude_max_list = [DD1, DD2, DD3, DD5, DD6];
                        console.log("exclude_max_list9="+exclude_max_list+" max="+maxList);

                    }else if(maxList == DD5 && (DD1 != null || DD2 != null || DD3 != null || DD4 != null || DD6 != null)){
                        var exclude_max_list = [DD1, DD2, DD3, DD4, DD6];
                        console.log("exclude_max_list10="+exclude_max_list+" max="+maxList);

                    }else if(maxList == DD6 && (DD1 != null || DD2 != null || DD3 != null || DD4 != null || DD5 != null)){
                        var exclude_max_list = [DD1, DD2, DD3, DD4, DD5];
                        console.log("exclude_max_list11="+exclude_max_list+" max="+maxList);

                    }else{
                        var exclude_max_list = $.grep( List, function( n ) { //make it array the remaining List
                            return n != maxList;
                        });
                        console.log("exclude_max_list="+exclude_max_list+" max="+maxList);
                    }
                }

                var new_list = eval(exclude_max_list.join("+")); //sum the array

                var EndingB = parseFloat(parseInt(new_list)) / parseFloat(parseInt(count+DDsum-1));

                console.log("SOF > 1 List="+List+" EndingB = "+parseFloat(parseInt(new_list))+" / "+parseFloat(parseInt(count+DDsum-1))+" == "+EndingB);

            } else {
                var new_list = parseFloat(parseInt(DD1))+parseFloat(parseInt(DD2))+parseFloat(parseInt(DD3))+parseFloat(parseInt(DD4))+parseFloat(parseInt(DD5))+parseFloat(parseInt(DD6));
                var EndingB = parseFloat(parseInt(new_list)) / parseFloat(parseInt(count+DDsum));
                console.log("SOF List="+List+" new_list="+new_list+" EndingB = "+EndingB);
            }
        }
        console.log("SOF DD1count="+DD1count+" DD2count="+DD2count+" DD3count="+DD3count+" DD4count="+DD4count+" DD5count="+DD5count+" DD6count="+DD6count+" DDsum="+DDsum+" count="+count);

        if (PF == 'W' && (EndingB / 1.5 / 0.15) >= 200) {
            var AAA = EndingB / 1.5 / 0.15;

        } else if ((PF == 'B' || PF == 'S') && (EndingB / 1.5 / 0.3) >= 200) {
            var AAA = EndingB / 1.5 / 0.3;

        } else {
            var AAA = EndingB / 1.5 / 0.3;
            $("#monthlyPayment").val('Not Qualify');
            $("#monthlyPayment").css({color: "red"});
        }

        if (numberOfYears <= 3) {

            if (loan == 0 && EXP == 1) {

                if (DL == 0 && (annualInterestRate * 0.22 - loanAmount) >= 200 && Math.min((annualInterestRate * 0.22 - loanAmount), Math.round((AAA - loanAmount), 2), 600) / 2 >= Math.abs(na)) {
                    $("#monthlyPayment").val(Math.min(Math.round(Math.min(Math.max((annualInterestRate * 0.20 - loanAmount), 200), 600), 2),
                        Math.round((AAA - loanAmount), 2)));

                } else if (DL == 1 && (annualInterestRate * 0.30 - loanAmount) >= 200 && Math.min((annualInterestRate * 0.22 - loanAmount), Math.round((AAA - loanAmount), 2), 600) / 2 >= Math.abs(na)) {
                    $("#monthlyPayment").val(Math.min(Math.round(Math.min(Math.max((annualInterestRate * 0.22 - loanAmount), 200), 600), 2),
                        Math.round((AAA - loanAmount), 2)));

                } else {
                    $("#monthlyPayment").val('Not Qualify');
                    $("#monthlyPayment").css({color: "red"});
                }

            } else if (loan == 0 && EXP == 0) {
                if (DL == 0 && (annualInterestRate * 0.30 - loanAmount) >= 500 && Math.min((annualInterestRate * 0.30 - loanAmount), Math.round((AAA - loanAmount), 2), 600) / 2 >= Math.abs(na)) {
                    $("#monthlyPayment").val(Math.min(Math.round(Math.min(Math.max((annualInterestRate * 0.22 - loanAmount), 500), 600), 2),
                        Math.round((AAA - loanAmount), 2)));
                    $("#monthlyPayment").css({color: "green"});

                } else if (DL == 0 && (annualInterestRate * 0.30 - loanAmount) < 500 && Math.min((annualInterestRate * 0.30 - loanAmount), Math.round((AAA - loanAmount), 2), 600) / 2 >= Math.abs(na) && (annualInterestRate * 0.30 - loanAmount) >= 200) {
                    $("#monthlyPayment").val(Math.min(Math.round((annualInterestRate * 0.30 - loanAmount), 2),
                        Math.round((AAA - loanAmount), 2)));
                    $("#monthlyPayment").css({color: "green"});

                } else if (DL == 1 && (annualInterestRate * 0.30 - loanAmount) >= 500 && Math.min((annualInterestRate * 0.31 - loanAmount), Math.round((AAA - loanAmount), 2), 600) / 2 >= Math.abs(na)) {
                    $("#monthlyPayment").val(Math.min(Math.round(Math.min(Math.max((annualInterestRate * 0.31 - loanAmount), 500), 600), 2),
                        Math.round((AAA - loanAmount), 2)));
                    $("#monthlyPayment").css({color: "green"});

                } else if (DL == 1 && (annualInterestRate * 0.30 - loanAmount) < 500 && Math.min((annualInterestRate * 0.31 - loanAmount), Math.round((AAA - loanAmount), 2), 600) / 2 >= Math.abs(na) && (annualInterestRate * 0.31 - loanAmount) >= 200) {
                    $("#monthlyPayment").val(Math.min(Math.round((annualInterestRate * 0.31 - loanAmount), 2),
                        Math.round((AAA - loanAmount), 2)));
                    $("#monthlyPayment").css({color: "green"});

                } else {
                    $("#monthlyPayment").val('Not Qualify');
                    $("#monthlyPayment").css({color: "red"});
                }

            } else if (loan == 1 && (
                    annualInterestRate * 0.35 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 1 && Port == 'SOF' && (
                    Math.min(Math.max(annualInterestRate * 0.35 - loanAmount, 200), 1000)) / 2 >= Math.abs(na) && (
                    annualInterestRate * 0.35 - loanAmount) >= 700) {
                $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.35 - loanAmount, 200), 1000), 2));
                $("#monthlyPayment").css({color: "green"});

            } else if (loan == 1 && (
                    annualInterestRate * 0.35 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 0 && Port == 'SOF' && (
                    Math.min(Math.max(annualInterestRate * 0.25 - loanAmount, 700), 1000)) / 2 >= Math.abs(na) && (
                    annualInterestRate * 0.35 - loanAmount) >= 700) {
                $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.25 - loanAmount, 700), 1000), 2));
                $("#monthlyPayment").css({color: "green"});

            } else if (loan > 1 && (
                    annualInterestRate * 0.40 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 1 && Port == 'SOF' && (
                    Math.min(Math.max(annualInterestRate * 0.40 - loanAmount, 200), 1000)) / 2 >= Math.abs(na) && (
                    annualInterestRate * 0.40 - loanAmount) >= 700) {
                $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.40 - loanAmount, 200), 1000), 2));
                $("#monthlyPayment").css({color: "green"});

            } else if (loan > 1 && (
                    annualInterestRate * 0.40 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 0 && Port == 'SOF' && Math.min(
                    Math.max(annualInterestRate * 0.30 - loanAmount, 700), 1000) / 2 >= Math.abs(na) && (
                    annualInterestRate * 0.40 - loanAmount) >= 700) {
                $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.30 - loanAmount, 700), 1000), 2));
                $("#monthlyPayment").css({color: "green"});

            } else if (loan == 1 && (annualInterestRate * 0.35 - loanAmount) >= 200 && (
                    annualInterestRate * 0.35 - loanAmount) <= 700 && Port == 'SOF' && (
                    annualInterestRate * 0.35 - loanAmount) / 2 >= Math.abs(na) && numberOfYears <= 3) {
                $("#monthlyPayment").val(Math.round((annualInterestRate * 0.35 - loanAmount), 2));
                $("#monthlyPayment").css({color: "green"});

            } else if (loan > 1 && (annualInterestRate * 0.40 - loanAmount) >= 200 && (
                    annualInterestRate * 0.40 - loanAmount) <= 700 && Port == 'SOF' && (
                    annualInterestRate * 0.40 - loanAmount) / 2 >= Math.abs(na) && numberOfYears <= 3) {
                $("#monthlyPayment").val(Math.round((annualInterestRate * 0.40 - loanAmount), 2));
                $("#monthlyPayment").css({color: "green"});

            } else {
                $("#monthlyPayment").val('Not Qualify');
                $("#monthlyPayment").css({color: "red"});
            }

        } else {
            $("#monthlyPayment").val('Not Qualify');
            $("#monthlyPayment").css({color: "red"});
        }

        if(AAA < 200){
            $("#monthlyPayment").val('Not Qualify');
            $("#monthlyPayment").css({color: "red"});
        }

        console.log("SOF loan="+loan+" Port="+Port+" EXP="+EXP+" DL="+DL+" na="+na+" loanAmount="+loanAmount+" numberOfYears="+numberOfYears+" annualInterestRate="+annualInterestRate+" PF="+PF+
            " DD1="+DD1+" DD2="+DD2+" DD3="+DD3+" DD4="+DD4+" DD5="+DD5+" AAA="+AAA+" count="+count+" list="+List+" EndingB="+EndingB+ " new_list="+new_list+ 'EndingB2 '+EndingB+ " = "+parseFloat(parseInt(new_list))+" / "+parseFloat(parseInt(count+DDsum))+" test1="+EndingB / 1.5 / 0.15+" test2="+EndingB / 1.5 / 0.3);
    }

});