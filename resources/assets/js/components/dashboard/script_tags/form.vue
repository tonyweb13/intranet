<template>
    <div class="panel-body">
            <div class="col-lg-12">
                <form @submit.prevent="createScript">
                    <form-group label="Script Title">
                        <div class="asterisk_label">*</div>
                        <input class="form-control input-sm" name="title" type="text" placeholder="Script Title"
                            v-model="script.title" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Script Title') }" >
                        <div class="pull-right">
                            <i v-show="errors.has('Script Title')" class="input_warning_icon fa fa-warning"></i>
                        </div>
                        <span v-show="errors.has('Script Title')" class="help is-danger">{{ errors.first('Script Title') }}</span>
                    </form-group>
                    <form-group label="Script Tags">
                        <div class="asterisk_label">*</div>
                        <vue-editor v-model="script.tags" useCustomImageHandler @imageAdded="handleImageAdded"/>
                    </form-group>
                    <save-button :disabled='!isComplete' />
                    <br/>
                </form>
            </div>
        <br/>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                laddabtn: '',
                script: {
                    tags: '',
                    title: '',
                },
            }
        },
        computed:{
            isComplete () {
                return this.script.title && this.script.tags;
            }, 
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        methods: {
            createScript: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let script = this.script;
                        let getAxios = '';
                        
                        getAxios = this.$constants.Dashboard_API.get("/scripts/create", {
                                params: {
                                    scripts: script.tags,
                                    title: script.title,
                                }
                            });

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('getScripts');
                            this.script.tags = null;
                            this.script.title = null;
                            swal({
                                text: 'Saved!',
                                type: "success",
                            });
                        }).then(() => {
                            this.$validator.reset();
                        }).catch(error => {
                            this.laddabtn.stop();
                            swal({
                                text: error,
                                type: "error",
                            });
                        });
                    }                
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

            }   
        }
    }
</script>