<template>
    <div>
        <el-form-item>
            <div slot="label">
                {{ listItem.label }}
                <el-tooltip v-if="listItem.help_text" effect="dark" :content="listItem.help_text" placement="top">
                <i class="tooltip-icon el-icon-info"></i>
            </el-tooltip>
            </div>
            <el-radio-group v-model="editItem.settings[prop]">
                <el-radio v-for="opt, i in listItem.options" :label="opt.value" :key="i">{{ opt.label }}</el-radio>
            </el-radio-group>
        </el-form-item>
        <template v-if="editItem.settings[prop]">
            <el-form-item v-for="field in listItem.fields" :key="field.key">
                <ElLabel slot="label" :label="field.label" :helpText="field.help_text"></elLabel>
                <el-input :value="field.value" v-model="editItem.settings[field.key]" :type="field.type"></el-input>
            </el-form-item>
        </template>
      
    </div>
</template>
<script>
import ElLabel from "../../includes/el-label.vue";

export default {
    name: "radioConditionFields",
    props: {
        editItem: Object,
        prop: String,
        listItem: Object
    },
    components: { ElLabel },
}
</script>