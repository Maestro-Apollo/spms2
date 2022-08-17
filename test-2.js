function generalizedGCD(num, arr) {
    const lowest = Math.min(...arr);

    for (let factor = lowest; factor > 1; factor--) {
        let isCommonDivisor = true;

        for (let j = 0; j < num; j++) {
            if (arr[j] % factor !== 0) {
                isCommonDivisor = false;
                break;
            }
        }

        if (isCommonDivisor) {
            return factor;
        }
    }

    return 1;
}

console.log(generalizedGCD(5, [2, 4, 6, 8, 10]));