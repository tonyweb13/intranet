<template>
	<div class="row">
		<div class="ibox-content col-lg-12 p-md">
			<add-button @add="addEditRow()" textToAdd="Offense"/>

			<div class="tabs-container">
		        <ul class="nav nav-tabs">
		            <li class="active"><a data-toggle="tab" href="#tab-attendance" aria-expanded="true">Attendance</a></li>
		            <li class=""><a data-toggle="tab" href="#tab-fraud" aria-expanded="false">Fraud</a></li>
		            <li class=""><a data-toggle="tab" href="#tab-misconduct" aria-expanded="false">Misconduct</a></li>
		            <li class=""><a data-toggle="tab" href="#tab-ethics" aria-expanded="false">Poor Work Ethics</a></li>
		            <li class=""><a data-toggle="tab" href="#tab-negligence" aria-expanded="false">Negligence</a></li>
		            <li class=""><a data-toggle="tab" href="#tab-security" aria-expanded="false">Information Security</a></li>
		            <li class=""><a data-toggle="tab" href="#tab-house" aria-expanded="false">General House Rules</a></li>
		            <li class=""><a data-toggle="tab" href="#tab-company" aria-expanded="false">General Company Rules</a></li>
		        </ul>
		        <div class="tab-content">
		            <div class="clearfix"></div>

		            <div id="tab-attendance" class="tab-pane active">
		                <category-list :categoriesProps = "1" />
		            </div>
		            <div class="clearfix"></div>

		            <div id="tab-fraud" class="tab-pane">
		                <category-list :categoriesProps = "2" />
		            </div>
		            <div class="clearfix"></div>

		            <div id="tab-misconduct" class="tab-pane">
		                <category-list :categoriesProps = "3" />
		            </div>
		            <div class="clearfix"></div>

		            <div id="tab-ethics" class="tab-pane">
		                <category-list :categoriesProps = "4" />
		            </div>
		            <div class="clearfix"></div>

		            <div id="tab-negligence" class="tab-pane">
		               <category-list :categoriesProps = "5" />
		            </div>
		            <div class="clearfix"></div>

					<div id="tab-security" class="tab-pane">
		                <category-list :categoriesProps = "6" />
		            </div>
		            <div class="clearfix"></div>

		            <div id="tab-house" class="tab-pane">
		                <category-list :categoriesProps = "7" />
		            </div>
		            <div class="clearfix"></div>

		            <div id="tab-company" class="tab-pane">
		                <category-list :categoriesProps = "8" />
		            </div>
		            <div class="clearfix"></div>
		        </div>
	    	</div>

	    	<modal v-if="openModal" @close="openModal = false">
	            <h3 slot="header">{{ headerName }}</h3>
	            <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
	            <add-edit :offenseProps="offense_data" slot="body" />
	        </modal>
    	</div>
    </div>
</template>
<script>
	import categoryList from '../../../../components/hr/nte/offense/list.vue'
	import addEdit from '../../../../components/hr/nte/offense/addEdit.vue'

    export default {
        components: { categoryList, addEdit },
        data: function () {
            return {
            	openModal: false,
            	headerName: 'Add Offense',
                offense_data: {
                    off_category: '',
                    off_provision: '',
                    off_offense: '',
                    off_gravity: '',
                    off_corrective: '',
                },
            }
        },
        created() {
            this.$bus.$on('init_modal', (param) => {
                this.openModal = param;
            });
        },
        methods: {
        	addEditRow: function () {
                this.openModal = true;
                this.offense_data.off_category = '';
                this.offense_data.off_provision = '';
                this.offense_data.off_offense = '';
                this.offense_data.off_gravity = '';
                this.offense_data.off_corrective = '';
            },
        }
    }

</script>