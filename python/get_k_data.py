import sys
import tushare as ts

argv = sys.argv[1:]

try:
    code = argv[0]
except Exception as e:
    print('Code is required');
    exit(1)

start = argv[1] if len(argv) >= 2 else ''
end = argv[2] if len(argv) >= 3 else ''
ktype = argv[3] if len(argv) >= 4 else 'D'
autype = argv[4] if len(argv) >= 5 else 'qfq'

df = ts.get_k_data(code, start, end, ktype, autype)

print(df.to_json(orient='records'))