<template>
<div class="h-100 w-100 position: relative;">
    <input type="file" class="file-input position-absolute custom-file-input h-100 w-100" style="cursor: pointer;" @change="upload">
</div>
</template>

<script>

    export default {

        data ()
        {
            return {

            }
        },

        methods: {

            upload (event)
            {
                console.log('upload')
                console.log(event)

                var files = event.target.files || event.dataTransfer.files
                if (!files.length)
                    return

                let formData = new FormData();

                formData.append('file', event.target.files[0], event.target.files[0].name)

                axios.post(
                    '/data/settings/upload',
                    formData,
                    {
                        onUploadProgress: (progressEvent) => {
                            this.uploadProgress = Math.round( (progressEvent.loaded * 100) / progressEvent.total )
                        }
                    }
                )
                .then((response) => {
                    console.log('upload response')
                    console.log(response.data);

                    $('.file-input').val('')
                })
                .catch((error) => {
                    console.log('upload error')
                    console.log(error);

                    if(error.response) {
                        console.log(error.response)
                    }

                    $('.file-input').val('')

                });
            }

        }

    }

</script>
