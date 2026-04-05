# SCSS（Friend 2026 テーマ）

- **エントリ**: `style.scss` を編集の起点にしてください。
- **コンパイル**: VS Code の **Live Sass Compiler** で `style.scss` をコンパイルして CSS を出力します。
- **出力先**: ワークスペースの `.vscode/settings.json` で `savePath: "~/../../"` を指定してあり、テーマルートに `style.css` が出力されます。変更する場合は「設定」で `liveSassCompile.settings.formats` を編集してください。

構成: base（variables / reset / base / mixin）→ layout（header / footer）→ object/component → object/project → object/utility。
