

```bash
#!/usr/bin/env bash

function foo() {
  pwd
  date "+%Y-%m-%d %H:%M:%S"
}

# shellcheck disable=SC2087
(
  ssh -p22 ubuntu@101.34.52.7 <<- EOF
    $(declare -f)
    foo
EOF
) || exit 1

exit 0
```
