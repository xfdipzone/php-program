/** XOR 加密/解密文件 */
#define TRUE 1
#define FALSE 0

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <libgen.h>
#include <sys/stat.h>
#include <sys/types.h>
#include <errno.h>

// 输出信息
void msg_log(char *str);

// 判断文件是否存在
int file_exists(char *filename);

// 判断目录是否存在
int path_exists(char *path);

// 创建多级目录
int mkdir_recursive(char *path, mode_t mode);

// 主函数
int main(int argc, char *argv[])
{
    int keylen, index=0;
    char *source, *dest, *key, fBuffer[1], *tBuffer, bitKey, *destPath;

    FILE *fSource, *fDest;

    source = argv[1]; // 原文件
    dest = argv[2];   // 目的文件
    key = argv[3];    // 加密字串

    // 检查参数
    if(source==NULL || dest==NULL || key==NULL)
    {
        msg_log("param error\nusage:XorEncryptor source dest key\ne.g ./XorEncryptor o.txt d.txt 123456");
        exit(0);
    }

    // 判断原文件是否存在
    if(file_exists(source)==FALSE)
    {
        tBuffer = (char *)malloc((strlen(source)+12) * sizeof(char));
        sprintf(tBuffer, "%s not exists", source);
        msg_log(tBuffer);
        exit(0);
    }

    // 获取key长度
    keylen = strlen(key);

    // 创建目标文件目录
    destPath = dirname(dest);

    if(!path_exists(destPath))
    {
        if(mkdir_recursive(destPath, 0777)==-1)
        {
            msg_log("dest path create fail");
            exit(0);
        }
    }

    fSource = fopen(source, "rb");
    fDest = fopen(dest, "wb");

    while(!feof(fSource))
    {
        fread(fBuffer, 1, 1, fSource); // 读取1字节

        if(!feof(fSource))
        {
            bitKey = key[index%keylen];   // 循环获取key
            *fBuffer = *fBuffer ^ bitKey; // xor encrypt
            fwrite(fBuffer, 1, 1, fDest); // 写入文件
            index ++;
        }
    }

    fclose(fSource);
    fclose(fDest);

    msg_log("success");

    exit(0);
}

//输出信息
void msg_log(char *str)
{
    printf("%s\n", str);
}

// 判断文件是否存在
int file_exists(char *filename)
{
    return (access(filename, F_OK)==0);
}

// 判断目录是否存在
int path_exists(char *path)
{
    return (access(path, F_OK)==0);
}

// 创建多级目录
int mkdir_recursive(char *path, mode_t mode)
{
    char *p = strdup(path);
    char *sep = strchr(p + 1, '/');

    while(sep != NULL)
    {
        *sep = '\0';
        if(mkdir(p, mode)!=0)
        {
            if(errno != EEXIST)
            {
                free(p);
                return -1; // 目录创建失败
            }
        }

        *sep = '/';
        sep = strchr(sep + 1, '/');
    }

    if(mkdir(p, mode)!=0)
    {
        if(errno != EEXIST)
        {
            free(p);
            return -1; // 目录创建失败
        }
    }
    free(p);
    return 0; // 目录创建成功
}