// import momentjs from 'moment'
export default {
    methods : {
        // payfrequency : function (dates)
        // {
        //     // dates = dates.sort(function(a, b){return b-a});
        //     console.log(dates);
        //     console.log(dates.length);
        //     let dates_diff = [], payfrequency = 'Unknown Payroll Frequency';
        //     for (let i = 0; i < dates.length; ++i) {
        //         console.log(dates[i]);
        //         var date1loop = new Date((i === 0 ) ? dates[i] : dates[i-1]);
        //         var date2loop = new Date((i === 0 ) ? dates[i+1] : dates[i]);
        //
        //         dates_diff.push(Math.abs(((date1loop - date2loop)/1000/60/60/24)));
        //         i = (i === 0 ) ? i+1: i;
        //     }
        //
        //     console.log(dates_diff);
        //
        //     let payfrequency_error = '';
        //     if(dates_diff.length > 1) {
        //         for (let i=1; i<dates_diff.length; i++) {
        //             payfrequency_error = dates_diff[i-1] != dates_diff[i] ? 'error' : 'false';
        //         }
        //     }   else {
        //         payfrequency = 'Bi-Weekly';
        //         console.log('lessthan 2');
        //     }
        //
        //     console.log(payfrequency);
        //
        //
        //     console.log(dates_diff.length);
        //     console.log(payfrequency_error);
        //
        //
        // },
        alertErrorList : function (response , success = false)
        {
            document.body.style.cursor='auto';
            var arr = Object.values(response);
            var iterator = Object.values(response.errors);


            if(iterator.length > 0) {

                let list_errors = [];
                let err = '';

                for (var i = 0; i < iterator.length; ++i) {
                  list_errors.push(iterator[i]);
                        // alert('value at index [' + i + '] is: [' + err[i] + ']');
                }

                list_errors = [].concat(...list_errors);

                for (var i = 0; i < list_errors.length; ++i) {
                    err += (i + 1) + '.' + list_errors[i] + '<br>';
                }

                var popup_msg =   '<div style="text-align:left;"> <h3>Please correct the following errors </h3>' + err + '</div>';

                swal({
                    type: 'warning',
                    title: 'Validation Error!',
                    html: popup_msg,
                });


                return;
            }

            if(success) {
                swal({
                    type: 'success',
                    title: 'Good job!',
                    html: 'Application successfully submitted',
                });

            }




        }
    }
        // ajaxGet : function(method, path, data, errorsc, success) {
        //     $.ajax({
        //         method: method,
        //         data: data,
        //         dataType: 'json',
        //         cache: false,
        //         contentType: "application/json",
        //         timeout: 0,
        //         url: path,
        //         error : errorsc,
        //         success : success,
        //     });
        // }

}

