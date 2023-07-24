import {defineConfig,splitVendorChunkPlugin} from 'vite';
import {resolve} from 'path';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import {ElementPlusResolver} from 'unplugin-vue-components/resolvers'


const projectRootDir = resolve(__dirname);

export default defineConfig({
    plugins: [
        splitVendorChunkPlugin(),
        laravel({
            buildDirectory: "admin/build",
            input: [
                'resources/js/admin.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        AutoImport({
            resolvers: [ElementPlusResolver()],
        }),
        Components({
            resolvers: [ElementPlusResolver({
                importStyle: 'sass',
            })],
        }),
    ],
    resolve: {
        alias: {
            '@': resolve(projectRootDir, 'resources/js/Admin'),
            '~': resolve(projectRootDir, 'resources'),
        },
        extensions: ['.js', '.vue', '.json'],
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@use "~/sass/element/index.scss" as *;`,
            },
        },
    },

    build: {
        sourcemap: false,
        rollupOptions: {
            output: {
                manualChunks: (id) => {

                    if (id.includes("node_modules")) {
                        if (id.includes("@fortawesome/fontawesome-svg-core")) {
                            return "@fortawesome/fontawesome-svg-core";
                        } else if (id.includes("@fortawesome/free-brands-svg-icons")) {
                            return " @fortawesome/free-brands-svg-icons";
                        } else if (id.includes("@fortawesome/free-regular-svg-icons")) {
                            return "@fortawesome/free-regular-svg-icons";
                        } else if (id.includes("@fortawesome/free-solid-svg-icons")) {
                            return "@fortawesome/free-solid-svg-icons";
                        } else if (id.includes("@fortawesome/vue-fontawesome")) {
                            return "@fortawesome/vue-fontawesome";
                        } else if (id.includes("lodash")) {
                            return "lodash";
                        }else if (id.includes("element-plus")) {
                            return "element";
                        }
                        // return 'node_modules';// all other package goes here
                    } else {
                        if (id.includes("Components")) {
                            return "components";
                        } else if (id.includes("Composables")) {
                            return "composables";
                        } else if (id.includes("Layouts")) {
                            return "layouts";
                        } else if (id.includes("Pages")) {
                            return "pages";
                        }
                    }
                },
            }
        },
    },
});
