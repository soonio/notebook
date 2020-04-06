import os
import csv
import xlrd


file_dir = './201811-01-19'

# 扫描目录文件


def scanpath(filepath, suffix):
    filelist = []
    print("开始扫描【{0}】".format(filepath))
    if not os.path.isdir(filepath):
        print("【{0}】不是目录".format(filepath))
        exit(-1)
    for filename in os.listdir(filepath):
        if os.path.isdir(filepath + "/" + filename):
            filelist.extend(scanpath(filepath + "/" + filename, suffix))
        else:
            if filename.endswith(suffix):
                filelist.append((filepath, filename))

    return filelist


paths = scanpath(file_dir, '')

filename = []

for x in paths:
    if x[1][0] == "【":  # 过滤非"【"开头的文件
        filename.append(x[0] + '/' + x[1])

filename = sorted(filename)

csvFile = open(file_dir + ".csv", "w", encoding='utf8', newline='')

writer = csv.writer(csvFile)

first_flag = True

for fn in filename:
    print(fn)
    with xlrd.open_workbook(fn, 'r') as excel:
        sheet = excel.sheet_by_index(0)
        for r in range(sheet.nrows):
            if r == 0 and not first_flag:
                continue
            else:
                first_flag = False

            row_data = []
            for c in range(sheet.ncols):
                row_data.append(sheet.cell_value(r, c))

            writer.writerow(row_data)

csvFile.close()
