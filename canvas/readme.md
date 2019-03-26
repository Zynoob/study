#less使用
```
npm install less -g //全局安装
npm install less -S //安装到package.json的dependencies
npm install less -D //安装到package.json的devDependencies
```
###.less文件如何变成.css文件
**例子: Compile foobar.less to foobar.css**
```
lessc foobar.less > foobar.css
```
---
#sass使用
```
npm install node-sass -g //全局安装
npm install node-sass -S //安装到package.json的dependencies
npm install node-sass -D //安装到package.json的devDependencies
```

###.scss文件如何变成.css文件
**例子: Compile foobar.scss to foobar.css**
```
node-sass foobar.scss > foobar.css
```
**加点东西可以使编译结果与less一样**
```
node-sass --output-style expanded foobar.scss > foobar.css
```