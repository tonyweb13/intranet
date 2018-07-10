<template>
 <div id="corrections">

    <div class="row" >
        <div class="col-md-4" v-for="(item, index ) in correction_items">
            <h4 style="border-bottom:1px solid #CBC8C8;padding:5px 0px;">{{item.correction_name}}</h4>
            <ul class="lsitemcat" >
                <li v-for="(item_child, index_child ) in item.correction_items">
                    <input type="checkbox" :value="item_child.id" v-model="corrections_list.checklist"  :name="'correction_items[' + item_child.id +']'" >
                    {{item_child.correction_name}}
                </li>
            </ul>
            <div class="clear-fix"></div>
        </div>

    </div>

     <div class="row" >
         <h4 style="border-bottom:1px solid #CBC8C8;padding:5px 0px;">Please fill out below for others ( Min 10 Characters)</h4>
         <textarea name="others_text" id="otherstext"
                  v-model="corrections_list.others"
                   rows="2"
                   class="form-control" style="background-color: rgb(253, 253, 195); padding: 5px 10px; margin: 0px 44.1944px 0px 0px; width: 100%; height: 50px;"

         >
         </textarea>

         <div class="clear-fix"></div>
     </div>

</div>
</template>
<style scoped>

.modal-footer .btn{
    margin:0px 10px !important;
}

ul {
    padding: 0px;
}

.lsitemcat li {
  list-style: none;
  margin: 3px 0px 0px 0px;
  padding: 1px 1px;
}

.lsitemcat li input {
    margin-right:5px;
}

/*.lsitemcat li {*/
  /*list-style: none;*/
  /*width: 25%;*/
  /*margin: 3px 0px;*/
  /*display: inline-table;*/
  /*padding: 5px 5px;*/
/*}*/

</style>
<script>
    'use strict';

    export default {
        data() {
            return {
                correction_items : [],
                corrections_list : { checklist : [], others : ''},
            }
        },
        props : {

        },
        created: function () {


        },
        computed: {

        },
        watch : {
            corrections_list: {
                handler: function() {
                    console.log(this.corrections_list.checklist);
                    this.$emit('corrections', [this.corrections_list.checklist, this.corrections_list.others ]);
                },
                deep: true
            }
        },
        updated () {

        },
        mounted() {
            this.correctionItems();
        },
        methods: {
            correctionItems : function() {

                this.$constants.LoanApp_API.get('/corrections/').then(response => {
                    console.log(response.data);
                    this.correction_items = response.data;
                }).catch(e => {
                    console.log(e);
                    swal({type: 'error', title: 'Unable to Retrieve Application', html:  'Please Check the Application ID : ' + e,});
                });
            }
        },


    }
</script>
