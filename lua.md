// eval "local t = redis.call('SET', KEYS[1], ARGV[1], 'NX', 'PX', ARGV[2]) ; if type(t) == 'table' then for key,value in pairs(t) do return {key, value} end else return t end" 1 uuu 111 10000
// eval "local t = redis.call('SET', KEYS[1], ARGV[1], 'NX', 'PX', ARGV[2]) ; if type(t) == 'table' then for key,value in pairs(t) do return {key, value} end else return t == false end" 1 uuu 111 100000



var (
	singleScript = red.NewScript(`if redis.call("EXISTS", KEYS[1]) == 0 then
    if redis.call("SET", KEYS[1], ARGV[1], "NX", "PX", ARGV[2]) ~= false then
        local ot = redis.call("GET", KEYS[2])
        if type(ot) == "string" and ot ~= "" then redis.call("DEL", ot) end
        return redis.call("SET", KEYS[2], KEYS[1], "PX", ARGV[2])
    else
        return 0
    end
else
    return 0
end`)
)