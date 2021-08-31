module.exports = {
    presets: [
        [
            "@babel/preset-env",
            {
                "corejs": { "version":3 },
                "useBuiltIns": "usage",
                "targets": "> 0.25%, not dead, ie <= 0",
            }
        ]
    ],
    sourceType: "unambiguous",
};