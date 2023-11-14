import {defineConfig, splitVendorChunkPlugin} from 'vite';
import {resolve} from 'path';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';


const projectRootDir = resolve(__dirname);

export default defineConfig({
    plugins: [
        // splitVendorChunkPlugin(),
        laravel({
            buildDirectory: "web-site/build",
            input: [
                'resources/js/site.js',
                ],
            refresh: true,
            optimizeDeps:{
                vendorChunk:true,
                preBundleDependencies: true,
                exclude:['@types/*'],
            }
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': resolve(projectRootDir, 'resources/js/Site'),
            '@admin': resolve(projectRootDir, 'resources/js/Admin'),
            '~': resolve(projectRootDir, 'resources'),
            'ziggy': resolve(projectRootDir,'vendor/tightenco/ziggy/src/js'),
            'ziggy-vue': resolve(projectRootDir,'vendor/tightenco/ziggy/src/js/vue'),
        },
        extensions: ['.js', '.vue', '.json'],
    },
    optimizeDeps: {
        exclude: ['js-big-decimal']
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
                        }
                        // return id.toString().split('node_modules/')[1].split('/')[0].toString();// all other package goes here
                    }
                    else
                    {
                        if(id.includes("Components"))
                        {
                            return "components";
                        }
                        else if(id.includes("Composables"))
                        {
                            return "composables";
                        }else if(id.includes("Layouts"))
                        {
                            return "layouts";
                        }else if(id.includes("Pages"))
                        {
                            return "pages";
                        }
                    }
                },
            },
        },
    },
});
