

Vue.component('uploader', {
  props: ['uploadUrl', 'src', 'val', 'name', 'multiple', 'fieldName'],
  created: function () {
    console.log(this.src);
    if (this.src) {
      this.image = this.src;
      console.log(this.src)
    }
    if (this.val) this.fieldValue = this.val;
  },
  methods: {
    select: function () {
      this.$refs.fileUpload.click();
    },
    remove: function () {
      this.image = null;
      this.fieldValue = null;

    },
    changed: function () {
      var _this = this;
      var f = new FormData();
      if (this.multiple) {
        for (var i = 0; i < this.$refs.fileUpload.files.length; i++) {
          f.append(this.fieldName, this.$refs.fileUpload.files[i]);
        }
      } else {
        f.append(this.fieldName, this.$refs.fileUpload.files[0]);
      }
      axios.post(this.uploadUrl, f, {
        onUploadProgress: progressEvent => {
          _this.progress = Math.ceil((progressEvent.loaded / progressEvent.total) * 100);
          console.log(_this.progress);
        },
        headers: {
          'Content-Type': 'multipart/form-data',
        }
      })
        .then(function (d) {
          _this.image = d.data.url;
          _this.fieldValue = d.data.path;
          _this.progress = 0;
        })
        .catch(function () {
          _this.$refs.fileUpload.value = '';
          _this.progress = 0;
        });
    }
  },
  data: function () {
    return {
      placeholder: 'https://themastersnook.com/images/placeholder.png',
      image: null,
      fieldValue: null,
      progress: 0
    }
  },
  template: '   <div>\n' +
    '         <input  :id="name" :value="fieldValue" type="hidden" v-if="name" :name="name">\n' +
    '         <img :id="name+\'-img\'" class="img-fluid" @click="select()" :src="image? image:placeholder" alt="">\n' +
    '         <input @change="changed()" :multiple="multiple" class="d-none" type="file" ref="fileUpload">\n' +
    '         <a v-if="image" @click="remove()" class="d-block text-center"><i class="fa fa-trash mr-2"></i>Remove</a>\n' +
    '         <a v-if="!image" @click="select()" class="d-block mt-1 text-center"><i class="fa fa-upload mr-2"></i>Upload</a>\n' +
    '         <label for="" v-if="progress>0">Uploaded @{{progress}}%</label>\n' +
    '      </div>'
});
Vue.component('multi-uploader', {
  props: ['uploadUrl', 'src', 'val', 'id', 'name', 'fieldName', 'base'],
  created: function () {
    if (this.val) this.images = this.val;
  },
  methods: {
    select: function () {
      this.$refs.fileUpload.click();
    },
    remove: function () {
      this.image = null;
      this.fieldValue = null;

    },
    changed: function () {
      var _this = this;
      var f = new FormData();

      for (var i = 0; i < this.$refs.fileUpload.files.length; i++) {
        f.append(this.fieldName + '[' + i + ']', this.$refs.fileUpload.files[i]);
      }

      f.append('id', this.id);
      axios.post(this.uploadUrl, f, {
        onUploadProgress: progressEvent => {
          _this.progress = Math.ceil((progressEvent.loaded / progressEvent.total) * 100);
          console.log(_this.progress);
        },
        headers: {
          'Content-Type': 'multipart/form-data',
        }
      }).then(function (d) {
        _this.images = _this.images.concat(d.data.images);

        _this.fieldValue = d.data.path;
        _this.progress = 0;
      }).catch(function (d) {
        console.log(d);
        _this.$refs.fileUpload.value = '';
        _this.progress = 0;
      });
    },
    getImg: function (x) {
      var arr = x.split('####');
      return $arr[1];
    }
  },
  data: function () {
    return {
      images: [],
      fieldValue: null,
      progress: 0
    }
  },
  template: ' <div><div><img style="width: 100px;margin-right: 10px;margin-bottom: 10px;" v-for="img in images" :src="img.path_small" alt=""></div> ' +
    '<input style="display: none;" v-for="im in images" :value="im.path_big+\'####\'+im.path_small" type="text" :name="\'rim[\'+id+\'][]\'" id="">\n' +
    '         <input  :id="name" :value="fieldValue" type="hidden" v-if="name" :name="name">\n' +
    '         <input accept=".jpg,.pmg,.jpeg" @change="changed()"  multiple  class="d-none" type="file" ref="fileUpload">\n' +
    '         <a @click="select()" class="d-block btn btn-success mt-1 text-center"><i class="fa fa-upload mr-2"></i>Upload</a>\n' +
    '         <label for="" v-if="progress>0">Uploaded @{{progress}}%</label>\n' +
    '      </div>'
});
Vue.component('rating', {
  props: ['rating'],
  data: function () {
    return {
      total: [1, 2, 3, 4, 5]
    }
  },
  template: '<div><span class="v-star-rating" v-for="s in total" href=""><i v-if="rating>=s" class="fa fa-star"></i><i v-if="rating<s" class="fa fa-star-o"></i></span></div>'
})

//
