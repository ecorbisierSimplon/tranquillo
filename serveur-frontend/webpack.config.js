const webpack = require("@nativescript/webpack");

module.exports = (env) => {
  webpack.init(env);

  // Learn how to customize:
  // https://docs.nativescript.org/webpack
  webpack.mergeWebpack({
    resolve: { conditionNames: ["svelte", "require", "node"] },
  });

  return webpack.resolveConfig();
};

// const { relative, resolve, sep } = require("path");

// const webpack = require("@nativescript/webpack");
// const CleanWebpackPlugin = require("clean-webpack-plugin");
// const CopyWebpackPlugin = require("copy-webpack-plugin");
// const { BundleAnalyzerPlugin } = require("webpack-bundle-analyzer");
// const TerserPlugin = require("terser-webpack-plugin");

// const nsWebpack = require("nativescript-dev-webpack");
// const nativescriptTarget = require("nativescript-dev-webpack/nativescript-target");
// const {
//   NativeScriptWorkerPlugin,
// } = require("nativescript-worker-loader/NativeScriptWorkerPlugin");

// module.exports = (env) => {
//   // Add your custom Activities, Services and other android app components here.
//   const appComponents = [
//     "@nativescript/core/ui/frame",
//     "@nativescript/core/ui/frame/activity",
//   ];

//   const platform = env && ((env.android && "android") || (env.ios && "ios"));
//   if (!platform) {
//     throw new Error("You need to provide a target platform!");
//   }

//   const platforms = ["ios", "android"];
//   const projectRoot = __dirname;

//   // Default destination inside platforms/<platform>/...
//   const dist = resolve(
//     projectRoot,
//     nsWebpack.getAppPath(platform, projectRoot)
//   );
//   const appResourcesPlatformDir = platform === "android" ? "Android" : "iOS";

//   const {
//     // The 'appPath' and 'appResourcesPath' values are fetched from
//     // the nsconfig.json configuration file
//     // when bundling with `tns run android|ios --bundle`.
//     appPath = "app",
//     appResourcesPath = "app/App_Resources",

//     // You can provide the following flags when running 'tns run android|ios'
//     snapshot, // --env.snapshot
//     production, // --env.production
//     report, // --env.report
//     hmr, // --env.hmr
//   } = env;

//   const externals = (env.externals || []).map((e) => {
//     // --env.externals
//     return new RegExp(e + ".*");
//   });

//   const mode = production ? "production" : "development";

//   const appFullPath = resolve(projectRoot, appPath);
//   const appResourcesFullPath = resolve(projectRoot, appResourcesPath);

//   const entryModule = nsWebpack.getEntryModule(appFullPath);
//   const entryPath = `.${sep}${entryModule}.ts`;
//   console.log(`Bundling application for entryPath ${entryPath}...`);

//   const config = {
//     mode: mode,
//     context: appFullPath,
//     externals,
//     watchOptions: {
//       ignored: [
//         appResourcesFullPath,
//         // Don't watch hidden files
//         "**/.*",
//       ],
//     },
//     target: nativescriptTarget,
//     // target: nativeScriptVueTarget,
//     entry: {
//       bundle: entryPath,
//     },
//     output: {
//       pathinfo: false,
//       path: dist,
//       libraryTarget: "commonjs2",
//       filename: "[name].js",
//       globalObject: "global",
//     },
//     resolve: {
//       mainFields: ["svelte", "module", "browser", "main"],
//       extensions: [".mjs", ".js", ".ts", ".scss", ".css"],
//       // Resolve {N} system modules from @nativescript/core
//       modules: [
//         resolve(__dirname, "node_modules/@nativescript/core"),
//         resolve(__dirname, "node_modules"),
//         "node_modules/@nativescript/core",
//         "node_modules",
//       ],
//       alias: {
//         "~": appFullPath,
//         "@": appFullPath,
//       },
//       // don't resolve symlinks to symlinked modules
//       symlinks: false,
//     },
//     resolveLoader: {
//       // don't resolve symlinks to symlinked loaders
//       symlinks: false,
//     },
//     node: {
//       // Disable node shims that conflict with NativeScript
//       http: false,
//       timers: false,
//       setImmediate: false,
//       fs: "empty",
//       __dirname: false,
//     },
//     devtool: "none",
//     optimization: {
//       splitChunks: {
//         cacheGroups: {
//           vendor: {
//             name: "vendor",
//             chunks: "all",
//             test: (module) => {
//               const moduleName = module.nameForCondition
//                 ? module.nameForCondition()
//                 : "";
//               return (
//                 /[\\/]node_modules[\\/]/.test(moduleName) ||
//                 appComponents.some((comp) => comp === moduleName)
//               );
//             },
//             enforce: true,
//           },
//         },
//       },
//       minimize: Boolean(production),
//       minimizer: [
//         new TerserPlugin({
//           parallel: true,
//           cache: true,
//           terserOptions: {
//             output: {
//               comments: false,
//             },
//             compress: {
//               // The Android SBG has problems parsing the output
//               // when these options are enabled
//               collapse_vars: platform !== "android",
//               sequences: platform !== "android",
//             },
//             safari10: platform === "ios",
//             keep_fnames: true,
//           },
//         }),
//       ],
//     },
//     module: {
//       rules: [
//         {
//           test: new RegExp(entryPath),
//           use: [
//             // Require all Android app components
//             platform === "android" && {
//               loader: "nativescript-dev-webpack/android-app-components-loader",
//               options: { modules: appComponents },
//             },

//             {
//               loader: "nativescript-dev-webpack/bundle-config-loader",
//               options: {
//                 registerPages: true, // applicable only for non-angular apps
//                 loadCss: !snapshot, // load the application css if in debug mode
//               },
//             },
//           ].filter((loader) => Boolean(loader)),
//         },
//         {
//           test: /\.css$/,
//           use: [
//             "nativescript-dev-webpack/style-hot-loader",
//             "nativescript-dev-webpack/apply-css-loader.js",
//             { loader: "css-loader", options: { minimize: false, url: false } },
//           ],
//         },
//         {
//           test: /\.scss$/,
//           use: [
//             "nativescript-dev-webpack/style-hot-loader",
//             "nativescript-dev-webpack/apply-css-loader.js",
//             { loader: "css-loader", options: { minimize: false, url: false } },
//             "sass-loader",
//           ],
//         },
//         {
//           test: /\.(js|ts)$/,
//           loader: "babel-loader",
//         },
//         {
//           test: /\.(html|svelte)$/,
//           exclude: /node_modules/,
//           use: "svelte-loader",
//         },
//       ],
//     },
//     plugins: [
//       // Define useful constants like TNS_WEBPACK
//       new webpack.DefinePlugin({
//         "global.TNS_WEBPACK": "true",
//         TNS_ENV: JSON.stringify(mode),
//       }),
//       // Remove all files from the out dir.
//       new CleanWebpackPlugin([`${dist}/**/*`]),
//       // Copy native app resources to out dir.
//       new CopyWebpackPlugin([
//         {
//           from: `${appResourcesFullPath}/${appResourcesPlatformDir}`,
//           to: `${dist}/App_Resources/${appResourcesPlatformDir}`,
//           context: projectRoot,
//         },
//       ]),
//       // Copy assets to out dir. Add your own globs as needed.
//       new CopyWebpackPlugin(
//         [
//           { from: "fonts/**" },
//           { from: "**/*.+(jpg|png)" },
//           { from: "assets/**/*" },
//         ],
//         { ignore: [`${relative(appPath, appResourcesFullPath)}/**`] }
//       ),
//       // Generate a bundle starter script and activate it in package.json
//       new nsWebpack.GenerateBundleStarterPlugin(["./vendor", "./bundle"]),
//       // For instructions on how to set up workers with webpack
//       // check out https://github.com/nativescript/worker-loader
//       new NativeScriptWorkerPlugin(),
//       new nsWebpack.PlatformFSPlugin({
//         platform,
//         platforms,
//       }),
//       // Does IPC communication with the {N} CLI to notify events when running in watch mode.
//       new nsWebpack.WatchStateLoggerPlugin(),
//     ],
//   };

//   if (report) {
//     // Generate report files for bundles content
//     config.plugins.push(
//       new BundleAnalyzerPlugin({
//         analyzerMode: "static",
//         openAnalyzer: false,
//         generateStatsFile: true,
//         reportFilename: resolve(projectRoot, "report", `report.html`),
//         statsFilename: resolve(projectRoot, "report", `stats.json`),
//       })
//     );
//   }

//   if (snapshot) {
//     config.plugins.push(
//       new nsWebpack.NativeScriptSnapshotPlugin({
//         chunk: "vendor",
//         requireModules: ["@nativescript/core/bundle-entry-points"],
//         projectRoot,
//         webpackConfig: config,
//       })
//     );
//   }

//   if (hmr) {
//     config.plugins.push(new webpack.HotModuleReplacementPlugin());
//   }
//   return config;
// };
