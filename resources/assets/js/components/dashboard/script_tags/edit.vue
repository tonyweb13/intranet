<template>
    <div class="col-lg-10 col-lg-offset-1">
        <ibox title="Edit Script">
            <div class="text-center article-title">
                <h1>
                    {{ this.title }}
                </h1>
            </div>
            <p style="word-break: break-all; margin:30px" v-if="!save" v-html="htmlForEditor" >
            </p>
            <div class="title-action">
                <button class="btn btn-white btn-sm" v-on:click="back()"><i class="fa fa-pencil"></i> Back</button>
                <button class="btn btn-info btn-sm" v-on:click="save = !save">
                    <span v-if="!save">Edit</span>
                    <span v-else>Cancel</span>
                </button>
            </div>
            <br/>
            <br/>
            <div v-if="save">
                <form>
                    <vue-editor v-model="htmlForEditor" useCustomImageHandler @imageAdded="handleImageAdded" />                     
                </form>
                <div class="title-action">
                    <button class="btn btn-primary btn-sm ladda-button" v-on:click="updateScript()" data-color="mint" data-style="slide-right"> Save</button>
                </div>
            </div>
        </ibox>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                save: false,
                edit: false,
                title: '',
                htmlForEditor: null,
                laddabtn: '',
            }
        },
        created() {
            this.getscripts();
        },
        methods: {
            getscripts: function() {
                this.$constants.Dashboard_API.get('/view/' + this.$route.params.script_id)
                .then(response => {
                    this.title = response.data[0].title;
                    this.htmlForEditor = response.data[0].scripts;
                });
            },
            updateScript: function () {
                
                let current_session = this.employee;
                // let full_name = current_session.first_name + ' ' + current_session.last_name;
                let userid = current_session.id;

                this.$constants.Dashboard_API.get('/scripts/' + this.$route.params.script_id, { 
                    params: {
                        title: this.title,
                        scripts: this.htmlForEditor,
                        updated_by: userid
                }})
                .then(response => {
                    this.edit = true;
                    this.save = false;                   
                    swal('','Successfully updating scripts!','success');
                })
                .catch(errors => {
                    swal('', errors, 'danger');                   
                });
            },
            handleImageAdded: function (file, Editor, cursorLocation, resetUploader) {
                let script = this.script;
                var formData = new FormData();
                formData.append('image', file);

                this.$constants.Dashboard_API.post("/script_tag/upload", formData)
                .then((result) => {
                    let url = result.data;
                    Editor.insertEmbed(cursorLocation, 'image', url);
                    resetUploader();
                })
                .catch((err) => {
                    swal({
                        text: err,
                        type: 'error'
                    });
                })
            },
            back: function () {
                this.$router.push('/settings/script');
            }
        }
    }
</script>