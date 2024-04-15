const appMixin = {
    methods: {
        /**
         * Translate the given key.
         */
        __(key, replace = {}, usePage = null) {
            const page = usePage ?? this.$page;
            let translation = page.props.language[key]
                ? page.props.language[key]
                : key

            Object.keys(replace).forEach(function (key) {
                translation = translation.replace(':' + key, replace[key])
            });

            return translation
        },
    },
};

export default appMixin;
