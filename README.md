#FuelPHP

* Version: 1.8
* [Website](http://fuelphp.com/)
* [Release Documentation](http://docs.fuelphp.com)
* [Release API browser](http://api.fuelphp.com)
* [Development branch Documentation](http://dev-docs.fuelphp.com)
* [Development branch API browser](http://dev-api.fuelphp.com)
* [Support Forum](http://fuelphp.com/forums) for comments, discussion and community support

### デモURL(heroku)
[デモURL](http://poker-fuel.herokuapp.com/hand)

### テスト用リポジトリ

入力フォームにてポーカーの役を成立する文字列数値を入れることにより、役を返す

#### 説明
```
【ポーカーの役】
ストレートフラッシュ: 同じスートで数字が連続する5枚のカードで構成されている場合
例: C7 C6 C5 C4 C3
 H1 H13 H12 H11 H10
フォー・オブ・ア・カインド: 同じ数字のカードが4枚含まれる場合
例: C10 D10 H10 S10 D5
 D6 H6 S6 C6 S13
フルハウス: 同じ数字のカード3枚と、別の同じ数字のカード2枚で構成されている場合
例: S10 H10 D10 S4 D4
 H9 C9 S9 H1 C1
フラッシュ: 同じスートのカード5枚で構成されている場合
例: H1 H12 H10 H5 H3
 S13 S12 S11 S9 S6
ストレート: 数字が連続した5枚のカードによって構成されている場合
例: S8 S7 H6 H5 S4
 D6 S5 D4 H3 C2
スリー・オブ・ア・カインド: 同じ数字の札3枚と数字の違う2枚の札から構成されている場合
例: S12 C12 D12 S5 C3
 C5 H5 D5 D12 C10
ツーペア: 同じ数の2枚組を2組と他のカード1枚で構成されている場合
例: H13 D13 C2 D2 H11
 D11 S11 S10 C10 S9
ワンペア: 同じ数字の2枚組とそれぞれ異なった数字の札3枚によって構成されている場合
例: C10 S10 S6 H4 H2
 H9 C9 H1 D12 D10
ハイカード: 上述の役が1つも成立しない場合
例: D1 D10 S9 C5 C4
 C13 D12 C11 H8 H7

```


#### バリデーション
- 数字チェック
- 半角スペースチェック
- スートチェック（S：スペード、H：ハート、D：ダイア、C：クラブ）
- 枚数チェック(5枚限定)
- 最大値13
- 最小値1
- 重複エラー
