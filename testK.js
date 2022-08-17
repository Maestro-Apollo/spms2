function isUnique(a) {
    let n = a.length;
    let ans = 0;
    for (let i = 1; i <= n; i++) {
        let flg = 1
        for (let j = 1; j <= n; j++) {
            if (i != j && a[i] == a[j]) flg = 0;
        }
        if (flg) { ans = a[i]; }
    }
    return ans;

}

console.log(isUnique([1, 2, 2, 3, 3, 4, 4]))