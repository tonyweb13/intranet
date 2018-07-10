<template>
    <div>
        <div class="row">
            <div class="col-lg-5">

                <vue-croppie
                    ref=croppieRef
                    :enableOrientation="true"
                    @result="result"
                    :mouseWheelZoom="false"
                    @update="update" />

            </div>
            <div class="col-lg-offset-2 col-lg-5">
                <img :src="image" class="img-responsive">
                <br>
                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput" style="white-space: nowrap;">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename" style="white-space: nowrap; width: 120px; overflow: hidden;text-overflow: ellipsis;"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                        <span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
                        <input type="hidden"><input type="file" v-on:change="onFileChange" name="image_file">
                    </span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
            </div>
        </div>
        <button class="ladda-button btn btn-success pull-right" data-color="mint" @click="crop" data-style="slide-right">Upload</button>
    </div>
</template>
<script>
    import axios from 'axios'

    export default {
        data: function() {
            return  {
                laddabtn : '',
                image: '',
            }
        },
        props: {
            imageProps: String,
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));

            this.$refs.croppieRef.bind({
                    url: this.imageProps,
            });
        },
        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    this.$refs.croppieRef.bind({
                        url: e.target.result,
                    })
                };
                reader.readAsDataURL(file);
            },
            exit : function () {
                this.$emit('event', false);
            },
            crop() {
                let options = {
                    format: 'jpeg', 
                    circle: false
                }
                this.$refs.croppieRef.result(options, (output) => {
                    this.image = output;
                    this.laddabtn.start();
                    let current_session = this.employee;
                    current_session.profile_pic = 'TEST';

                    axios.post('/api/vps/user_update/upload', {image: this.image})
                    .then(response => {
                        if (response.data.errors) {
                            this.laddabtn.stop();
                            swal('','Invalid file!', 'warning');
                        } else {
                            current_session.profile_pic =  response.data.file_name;
                            this.$session.set('user_session', current_session);
                            this.$bus.$emit('init_image', response.data.profile);
                            this.$bus.$emit('init_thumb', response.data.thumbnail);
                            this.$emit('event', false);
                            swal('', 'Uploaded Successfully!', 'success');
                            this.$router.go();

                        }
                    }).catch(error => {
                        this.laddabtn.stop();
                        swal('', 'Please import a valid Image', 'warning');
                    });
                });
            },
            result(output) {
                this.image = output;
            },
            update(val) {
                let options = {
                    format: 'jpeg', 
                    circle: false
                }
                this.$refs.croppieRef.result(options, (output) => {
                    this.image = output;
                });
            },     
        }

    }
</script>