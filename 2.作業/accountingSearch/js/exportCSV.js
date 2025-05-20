function exportCsv(filename, data) {
    // 配列をCSV文字列に変換する関数
    const arrayToCsv = (array) => {
        const headers = Object.keys(array[0]).join(",");
        const rows = array.map(row =>
            Object.values(row).map(value =>
                `"${String(value).replace(/"/g, '""')}"` // ダブルクォートをエスケープ
            ).join(",")
        );
        return [headers, ...rows].join("\n");
    };

    // データをCSV文字列に変換
    const csvContent = arrayToCsv(data);

    // Shift_JISエンコード
    const sjisArray = Encoding.convert(Encoding.stringToCode(csvContent), 'SJIS', 'UNICODE');
    const sjisBlob = new Blob([new Uint8Array(sjisArray)], { type: "text/csv;charset=shift-jis;" });

    // ダウンロード用のリンクを作成
    const link = document.createElement("a");
    const url = URL.createObjectURL(sjisBlob);
    link.setAttribute("href", url);
    link.setAttribute("download", filename);

    // リンクをクリックしてダウンロード
    link.style.visibility = "hidden";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

    /*const data = [
        { 名前: "山田 太郎", 年齢: 28, 性別: "男性", メールアドレス: "taro.yamada@example.com" },
        { 名前: "佐藤 花子", 年齢: 34, 性別: "女性", メールアドレス: "hanako.sato@example.com" },
        { 名前: "鈴木 一郎", 年齢: 22, 性別: "男性", メールアドレス: "ichiro.suzuki@example.com" },
        { 名前: "田中 美咲", 年齢: 29, 性別: "女性", メールアドレス: "misaki.tanaka@example.com" },
        { 名前: "高橋 健", 年齢: 40, 性別: "男性", メールアドレス: "ken.takahashi@example.com" }
    ];*/
