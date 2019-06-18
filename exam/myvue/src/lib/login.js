// 帐号是否合法(字母开头，允许5-16字节，允许字母数字下划线)
export function VerifyName(name) {
    return /^[a-zA-Z][a-zA-Z0-9_]{4,15}$/.test(name);
}

export function VerifyPassword(password){
    return /.{6,18}/.test(password);
}