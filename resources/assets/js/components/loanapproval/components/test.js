export default {
    matrix: function () {

            if (DD1 == '0') {
                var DD1count = 1;
            } else if (DD1 === null || DD1 == "") {
                var DD1 = 0;
            }
            if (DD2 == '0') {
                var DD2count = 1;
            } else if (DD2 === null || DD2 == "") {
                var DD2 = 0;
            }
            if (DD3 == '0') {
                var DD3count = 1;
            } else if (DD3 === null || DD3 == "") {
                var DD3 = 0;
            }
            if (DD4 == '0') {
                var DD4count = 1;
            } else if (DD4 === null || DD4 == "") {
                var DD4 = 0;
            }
            if (DD5 == '0') {
                var DD5count = 1;
            } else if (DD5 === null || DD5 == "") {
                var DD5 = 0;
            }
            if (DD6 == '0') {
                var DD6count = 1;
            } else if (DD6 === null || DD6 == "") {
                var DD6 = 0;
            }

            if (DD1count == undefined) {
                var DD1count = 0;
            }
            if (DD2count == undefined) {
                var DD2count = 0;
            }
            if (DD3count == undefined) {
                var DD3count = 0;
            }
            if (DD4count == undefined) {
                var DD4count = 0;
            }
            if (DD5count == undefined) {
                var DD5count = 0;
            }
            if (DD6count == undefined) {
                var DD6count = 0;
            }


            var DDsum = parseInt(DD1count) + parseInt(DD2count) + parseInt(DD3count) + parseInt(DD4count) + parseInt(DD5count) + parseInt(DD6count); //if I enter zero value


            var List = [DD1, DD2, DD3, DD4, DD5, DD6];

            var new_list = 0;

            var count = 0;


            for (var i = 0; i <= 6; i++) {
                if (Math.sign(List[i])) {
                    count++;
                }
            }

            var new_list = parseFloat(parseInt(DD1)) + parseFloat(parseInt(DD2)) + parseFloat(parseInt(DD3)) + parseFloat(parseInt(DD4)) + parseFloat(parseInt(DD5)) + parseFloat(parseInt(DD6));

            if (count == 0) {

                var EndingB = 9000;

            } else {
                if (count > 1) {

                    if (DD1 == DD2 && DD1 == DD3 && DD1 == DD4 && DD1 == DD5 && DD1 == DD6) {
                        var exclude_max_list = [DD2, DD3, DD4, DD5, DD6];
                        console.log("exclude_max_list5=" + exclude_max_list);

                    } else if (DD1 == DD2 && DD1 == DD3 && DD1 == DD4 && DD1 == DD5 && (DD6 == null)) {
                        var exclude_max_list = [DD2, DD3, DD4, DD5];
                        console.log("exclude_max_list4=" + exclude_max_list);

                    } else if (DD1 == DD2 && DD1 == DD3 && DD1 == DD4 && (DD5 == null || DD6 == null)) {
                        var exclude_max_list = [DD2, DD3, DD4];
                        console.log("exclude_max_list3=" + exclude_max_list);

                    } else if (DD1 == DD2 && DD1 == DD3 && (DD4 == null || DD5 == null || DD6 == null)) {
                        var exclude_max_list = [DD2, DD3];
                        console.log("exclude_max_list2=" + exclude_max_list);

                    } else if (DD1 == DD2 && (DD3 == null || DD4 == null || DD5 == null || DD6 == null)) {
                        var exclude_max_list = [DD2];
                        console.log("exclude_max_list1=" + exclude_max_list);

                    } else {

                        var maxList = Math.max.apply(null, List); //get max in array

                        if (maxList == DD1 && (DD2 != null || DD3 != null || DD4 != null || DD5 != null || DD6 != null)) {
                            var exclude_max_list = [DD2, DD3, DD4, DD5, DD6];
                            console.log("exclude_max_list6=" + exclude_max_list + " max=" + maxList);

                        } else if (maxList == DD2 && (DD1 != null || DD3 != null || DD4 != null || DD5 != null || DD6 != null)) {
                            var exclude_max_list = [DD1, DD3, DD4, DD5, DD6];
                            console.log("exclude_max_list7=" + exclude_max_list + " max=" + maxList);

                        } else if (maxList == DD3 && (DD1 != null || DD2 != null || DD4 != null || DD5 != null || DD6 != null)) {
                            var exclude_max_list = [DD1, DD2, DD4, DD5, DD6];
                            console.log("exclude_max_list8=" + exclude_max_list + " max=" + maxList);

                        } else if (maxList == DD4 && (DD1 != null || DD2 != null || DD3 != null || DD5 != null || DD6 != null)) {
                            var exclude_max_list = [DD1, DD2, DD3, DD5, DD6];
                            console.log("exclude_max_list9=" + exclude_max_list + " max=" + maxList);

                        } else if (maxList == DD5 && (DD1 != null || DD2 != null || DD3 != null || DD4 != null || DD6 != null)) {
                            var exclude_max_list = [DD1, DD2, DD3, DD4, DD6];
                            console.log("exclude_max_list10=" + exclude_max_list + " max=" + maxList);

                        } else if (maxList == DD6 && (DD1 != null || DD2 != null || DD3 != null || DD4 != null || DD5 != null)) {
                            var exclude_max_list = [DD1, DD2, DD3, DD4, DD5];
                            console.log("exclude_max_list11=" + exclude_max_list + " max=" + maxList);

                        } else {
                            var exclude_max_list = $.grep(List, function (n) { //make it array the remaining List
                                return n != maxList;
                            });
                            console.log("exclude_max_list=" + exclude_max_list + " max=" + maxList);
                        }
                    }

                    var new_list = eval(exclude_max_list.join("+")); //sum the array

                    var EndingB = parseFloat(parseInt(new_list)) / parseFloat(parseInt(count + DDsum - 1));

                    console.log("INBOX > 1 List=" + List + " EndingB = " + parseFloat(parseInt(new_list)) + " / " + parseFloat(parseInt(count + DDsum - 1)) + " == " + EndingB);

                } else {
                    var new_list = parseFloat(parseInt(DD1)) + parseFloat(parseInt(DD2)) + parseFloat(parseInt(DD3)) + parseFloat(parseInt(DD4)) + parseFloat(parseInt(DD5)) + parseFloat(parseInt(DD6));
                    var EndingB = parseFloat(parseInt(new_list)) / parseFloat(parseInt(count + DDsum));
                    console.log("INBOX List=" + List + " new_list=" + new_list + " EndingB = " + EndingB);
                }
            }



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

                    if (DL == 0 && (annualInterestRate * 0.25 - loanAmount) >= 200 && Math.min((annualInterestRate * 0.25 - loanAmount), Math.round((AAA - loanAmount), 2), 1000) / 2 >= Math.abs(na)) {
                        $("#monthlyPayment").val(Math.min(Math.round(Math.min(Math.max((annualInterestRate * 0.25 - loanAmount), 200), 1000), 2), Math.round((AAA - loanAmount), 2)));
                        $("#monthlyPayment").css({color: "green"});

                    } else if ((DL == 1 && (annualInterestRate * 0.35 - loanAmount) >= 200 && Math.min((annualInterestRate * 0.25 - loanAmount), Math.round((AAA - loanAmount), 2), 1500) / 2 >= Math.abs(na))) {
                        $("#monthlyPayment").val(Math.min(Math.round(Math.min(Math.max((annualInterestRate * 0.25 - loanAmount), 200), 1500), 2), Math.round((AAA - loanAmount), 2)));
                        $("#monthlyPayment").css({color: "green"});

                    } else {
                        $("#monthlyPayment").val('Not Qualify');
                        $("#monthlyPayment").css({color: "red"});
                    }

                } else if (loan == 0 && EXP == 0) {

                    if (DL == 0 && (annualInterestRate * 0.35 - loanAmount) >= 700 && Math.min((annualInterestRate * 0.35 - loanAmount), Math.round((AAA - loanAmount), 2), 1000) / 2 >= Math.abs(na)) {
                        $("#monthlyPayment").val(Math.min(Math.round(Math.min(Math.max((annualInterestRate * 0.25 - loanAmount), 700), 1000), 2), Math.round((AAA - loanAmount), 2)));
                        $("#monthlyPayment").css({color: "green"});

                    } else if (DL == 0 && (annualInterestRate * 0.35 - loanAmount) < 700 && Math.min((annualInterestRate * 0.35 - loanAmount), Math.round((AAA - loanAmount), 2), 1000) / 2 >= Math.abs(na) && (annualInterestRate * 0.35 - loanAmount) >= 200) {
                        $("#monthlyPayment").val(Math.min(Math.round((annualInterestRate * 0.35 - loanAmount), 2), Math.round((AAA - loanAmount), 2)));
                        $("#monthlyPayment").css({color: "green"});

                    } else if (DL == 1 && (annualInterestRate * 0.35 - loanAmount) >= 700 && Math.min((annualInterestRate * 0.35 - loanAmount), Math.round((AAA - loanAmount), 2), 1500) / 2 >= Math.abs(na)) {
                        $("#monthlyPayment").val(Math.min(Math.round(Math.min(Math.max((annualInterestRate * 0.35 - loanAmount), 700), 1500), 2), Math.round((AAA - loanAmount), 2)));
                        $("#monthlyPayment").css({color: "green"});

                    } else if (DL == 1 && (annualInterestRate * 0.35 - loanAmount) < 700 && Math.min((annualInterestRate * 0.35 - loanAmount), Math.round((AAA - loanAmount), 2), 1500) / 2 >= Math.abs(na) && (annualInterestRate * 0.35 - loanAmount) >= 200) {
                        $("#monthlyPayment").val(Math.min(Math.round((annualInterestRate * 0.35 - loanAmount), 2), Math.round((AAA - loanAmount), 2)));
                        $("#monthlyPayment").css({color: "green"});

                    } else {
                        $("#monthlyPayment").val('Not Qualify');
                        $("#monthlyPayment").css({color: "red"});
                    }

                } else if (loan == 1 && (
                    annualInterestRate * 0.40 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 1 && Port == 'INBX' && (
                    Math.min(Math.max(annualInterestRate * 0.40 - loanAmount, 200), 2500)) / 1.5 >= Math.abs(na) && (
                    annualInterestRate * 0.40 - loanAmount) >= 1100) {
                    $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.40 - loanAmount, 200), 5000), 2));
                    $("#monthlyPayment").css({color: "green"});

                } else if (loan == 1 && (
                    annualInterestRate * 0.40 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 0 && Port == 'INBX' && (
                    Math.min(Math.max(annualInterestRate * 0.30 - loanAmount, 1100), 5000)) / 1.5 >= Math.abs(na) && (
                    annualInterestRate * 0.40 - loanAmount) >= 1100) {
                    $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.30 - loanAmount, 1100), 5000), 2));
                    $("#monthlyPayment").css({color: "green"});

                } else if (loan > 1 && (
                    annualInterestRate * 0.45 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 1 && Port == 'INBX' && (
                    Math.min(Math.max(annualInterestRate * 0.45 - loanAmount, 200), 5000)) / 1.5 >= Math.abs(na) && (
                    annualInterestRate * 0.45 - loanAmount) >= 1100) {
                    $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.45 - loanAmount, 200), 5000), 2));
                    $("#monthlyPayment").css({color: "green"});

                } else if (loan > 1 && (
                    annualInterestRate * 0.45 - loanAmount) >= 200 && numberOfYears <= 3 && DL == 0 && Port == 'INBX' && Math.min(
                    Math.max(annualInterestRate * 0.35 - loanAmount, 1100), 5000) / 1.5 >= Math.abs(na) && (
                    annualInterestRate * 0.45 - loanAmount) >= 1100) {
                    $("#monthlyPayment").val(Math.round(Math.min(Math.max(annualInterestRate * 0.35 - loanAmount, 1100), 5000), 2));
                    $("#monthlyPayment").css({color: "green"});

                } else if (loan == 1 && (annualInterestRate * 0.40 - loanAmount) >= 200 && (
                    annualInterestRate * 0.40 - loanAmount) <= 1100 && Port == 'INBX' && (
                    annualInterestRate * 0.40 - loanAmount) / 1.5 >= Math.abs(na) && numberOfYears <= 3) {
                    $("#monthlyPayment").val(Math.round((annualInterestRate * 0.40 - loanAmount), 2));
                    $("#monthlyPayment").css({color: "green"});

                } else if (loan > 1 && (annualInterestRate * 0.45 - loanAmount) >= 200 && (
                    annualInterestRate * 0.45 - loanAmount) <= 1100 && Port == 'INBX' && (
                    annualInterestRate * 0.45 - loanAmount) / 1.5 >= Math.abs(na) && numberOfYears <= 3) {
                    $("#monthlyPayment").val(Math.round((annualInterestRate * 0.45 - loanAmount), 2));
                    $("#monthlyPayment").css({color: "green"});

                } else {
                    $("#monthlyPayment").val('Not Qualify');
                    $("#monthlyPayment").css({color: "red"});
                }

            } else {
                $("#monthlyPayment").val('Not Qualify');
                $("#monthlyPayment").css({color: "red"});
            }

            if (AAA < 200) {
                $("#monthlyPayment").val('Not Qualify');
                $("#monthlyPayment").css({color: "red"});
            }

            console.log("INBOX loan=" + loan + " Port=" + Port + " EXP=" + EXP + " DL=" + DL + " na=" + na + " loanAmount=" + loanAmount + " numberOfYears=" + numberOfYears + " annualInterestRate=" + annualInterestRate + " PF=" + PF +
                " DD1=" + DD1 + " DD2=" + DD2 + " DD3=" + DD3 + " DD4=" + DD4 + " DD5=" + DD5 + " AAA=" + AAA + " count=" + count + " list=" + List + " EndingB=" + EndingB + " new_list=" + new_list + " EndingB2 " + EndingB + " = " + parseFloat(parseInt(new_list)) + " / " + parseFloat(parseInt(count + DDsum)) + " approved_amount1=" + EndingB / 1.5 / 0.15 + " approved_amount2=" + EndingB / 1.5 / 0.3);

    },
}