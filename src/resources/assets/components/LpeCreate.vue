<template>
    <div class="row">
        <div class="col-lg-12">
            <b-card class="mb-2 bg-default-card" header="Tambah Laju Pertumbuhan Ekonomi (LPE) Provinsi Banten" header-tag="h4">
                <div>
                    <vue-form :state="formstate" @submit.prevent="onSubmit">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <validate tag="div">
                                        <label for="lpeprovinsiProvinceKode"> Provinsi</label>
                                        <select name="lpeprovinsiProvinceKode" class="form-control" id="lpeprovinsiProvinceKode" v-model="lpeprovinsiProvinceKode" @change="getKota()" required checkbox>
                                            <option value="0" selected disabled>Pilih Provinsi</option>
                                            <option :value="province.provinsi_kode" v-for="province in provinces">
                                                {{ province.provinsi_nama }}
                                            </option>
                                        </select>
                                        <field-messages name="lpeprovinsiProvinceKode" show="$invalid && $submitted" class="text-danger">
                                            <div slot="checkbox">Provinsi dibutuhkan.</div>
                                        </field-messages>
                                    </validate>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <validate tag="div">
                                        <label for="lpeprovinsiKotaKode"> Kota</label>
                                        <select name="lpeprovinsiKotaKode" class="form-control" id="lpeprovinsiKotaKode" v-model="lpeprovinsiKotaKode" required checkbox>
                                            <option value="0" selected disabled>Pilih Kota</option>
                                            <option :value="city.kota_kode" v-for="city in cities">
                                                {{ city.kota_nama }}
                                            </option>
                                        </select>
                                        <field-messages name="lpeprovinsiKotaKode" show="$invalid && $submitted" class="text-danger">
                                            <div slot="checkbox">Kota dibutuhkan.</div>
                                        </field-messages>
                                    </validate>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <validate tag="div">
                                        <label for="lpeprovinsiTgl"> Tanggal</label>
                                        <input type="date" name="lpeprovinsiTgl" class="form-control input-sm" id="lpeprovinsiTgl" value="yyyy-mm-dd" aria-selected="true" v-model="lpeprovinsiTgl" required>
                                        <field-messages name="lpeprovinsiTgl" show="$invalid && $submitted" class="text-danger">
                                            <div slot="required">Tanggal dibutuhkan.</div>
                                        </field-messages>
                                    </validate>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <validate tag="div">
                                        <label for="lpeprovinsiValue"> Jumlah</label>
                                        <input type="number" name="lpeprovinsiValue" class="form-control input-sm" id="lpeprovinsiValue" placeholder="Masukkan Jumlah" v-model="lpeprovinsiValue" required>
                                        <field-messages name="lpeprovinsiValue" show="$invalid && $submitted" class="text-danger">
                                            <div slot="required">Jumlah dibutuhkan.</div>
                                        </field-messages>
                                    </validate>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <b-button type="submit" size="md" variant="primary">
                                        <i class="ti-save"></i> Simpan
                                    </b-button>
                                    <router-link to="/" class="btn btn-danger"><i class="ti-arrow-left"></i> KEMBALI</router-link>
                                </div>
                            </div>
                        </div>
                    </vue-form>
                </div>
            </b-card>
        </div>
    </div>
</template>
<script>
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
export default {
    name: "lpecreate",
    data() {
        return {
            provinces: [],
            cities: [],
            lpeprovinsiProvinceKode: 0,
            lpeprovinsiKotaKode: 0,
            lpeprovinsiTgl: "",
            lpeprovinsiValue: 0,
            formstate: {}
        }
    },
    methods: {
        onSubmit: function() {
            if (this.formstate.$invalid) {
                return;
            } else {
                axios.post('/create', {
                    lpeprovinsiProvinceKode: this.lpeprovinsiProvinceKode,
                    lpeprovinsiKotaKode: this.lpeprovinsiKotaKode,
                    lpeprovinsiTgl: this.lpeprovinsiTgl,
                    lpeprovinsiValue: this.lpeprovinsiValue
                })
                .then(response => {
                    this.$router.push({ name: 'list'})
                })
                .catch(function(error) {});
            }

        },
        getKota: function () {
            var val = this.lpeprovinsiProvinceKode;
            axios.get("/getKota/"+val)
                .then(response => {
                    this.cities = response.data;
                })
                .catch(function(error) {});
        }
    },
    mounted: function() {
        axios.get("/getProvinsi")
            .then(response => {
                this.provinces = response.data;
            })
            .catch(function(error) {});
    },
    destroyed: function() {

    }
}
</script>