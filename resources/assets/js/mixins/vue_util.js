"use strict";

const ID_SUFFIX = '_id';

export default class VueUtil {
    constructor(component) {
        this.component = component;
        this.warn = this.component.$options.warn;
    }

    getSetting(name) {
        let setting = this.getOptionalSetting(name);
        if (!setting) {
            throw new Error("Couldn't find required setting: " + name);
        }
        return setting;
    }

    getOptionalSetting(name) {
        return this.component.$options[name];
    }

    hierarchy() {
        let names = [];
        let comp = this.component;
        while (true) {
            let name = comp.$options.name || '[unknown]';
            names.push(name);
            comp = comp.$parent;
            if (!comp) {
                break;
            }
        }
        return names.reverse().join('->');
    }

    countNestingOf(containerName) {
        let nesting = 0;
        let comp = this.component;
        while (comp) {
            if (comp.$options.name === containerName) {
                nesting++;
            }
            comp = comp.$parent;
        }
        return nesting;
    }

    fieldToPath(field) {
        // set the $field_path to the full path of the file, for example lead.first_name
        let ancestor_with_prefix = VueUtil.getAncestorSatisfying(this.component,
            (comp) => typeof(comp.prefix) !== 'undefined'
        );
        let field_path = this.component.field;
        // if the ancestor has the prefix '', don't bother appending to it
        if (ancestor_with_prefix) {
            let found_prefix = ancestor_with_prefix.prefix.trim();
            if (found_prefix === '') {
                throw new Error("Empty prefix not allowed");
            }
            let new_prefix = '';
            if (found_prefix.startsWith('\\')) {
                let prefix_without_slash = found_prefix.substring(1);
                if (prefix_without_slash !== '') {
                    new_prefix = prefix_without_slash + '.';
                }
            } else {
                new_prefix = found_prefix + '.';
            }
            field_path = new_prefix + this.component.field;
        }
        return field_path;
    }

    getValueFromFieldOrValue() {
        let value = this.component.value;
        if (typeof value === 'undefined') {
            value = this.component.getValue();
        }
        if (value === undefined) {
            this.warn('Data missing for field: ' + this.component.$field_path + ", hierarchy: " +
                this.hierarchy());
        }
        return value;
    }

    static getAncestorSatisfying(comp, satisfyFn) {
        let ancestor = null;
        while (comp) {
            if (satisfyFn(comp)) {
                ancestor = comp;
                break;
            }
            comp = comp.$parent;
        }
        return ancestor;
    }

    static fieldToTitle(field_name) {
        let title_no_colon = 'no_title_provided';
        if (field_name) {
            let field = field_name;
            // if the field ends in _id, then remove that
            if (field_name.endsWith(ID_SUFFIX)) {
                field = field.substring(0, field.length - ID_SUFFIX.length);
            }

            let parts = field.split('_');
            let new_parts = [];
            for (let part of parts) {
                new_parts.push(part.charAt(0).toUpperCase() + part.slice(1));
            }
            title_no_colon = new_parts.join(' ');
        }
        return title_no_colon;
    }

    static getFieldName(field) {
        let parts = field.split('.');
        return parts[parts.length-1];
    }

    // TODO: move the dot-notation stuff into a dot_notation_util class
    static extractWithDotNotation(root, field_path, stopOneEarlier) {
        if (!root) {
            throw new Error("getParentOfField got passed a null root");
        }

        let data = root;
        let parts = field_path.split('.');
        let len = parts.length;
        if (stopOneEarlier) {
            len--;
        }
        // we skip the last part of the path, which is the field name
        for (let i = 0; i < len; i++) {
            let part = parts[i];
            data = data[part];
            // don't try to dereference null/undefined, just abort
            if (!data) {
                break;
            }
        }
        return data;
    }

}
