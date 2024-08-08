const stringify = (val, replacer=' ', counter=1, depth = 1) => {
  if (val === null) {
    return 'null';
  }
  if (replacer === null) {
    replacer = ' ';
  }
  if (depth === null) {
    depth = 1;
  }
  switch (typeof val) {
    case 'string':
      return val;
    case 'number':
      return val.toString();
    case 'boolean':
      return val.toString();
    case 'object':
      let result = `{\n`;
      Object.entries(val).forEach(function (element) {
        result += `${replacer.repeat(counter * depth)}${element[0]}: `;
          depth += 1;
          result += `${stringify(element[1], replacer, counter, depth)}\n`
          depth -= 1;
      })
      result += depth > 1 ? `${replacer.repeat(counter * (depth - 1))}}` : `}`;
      return result;
    default:
      console.log('unknown type of value');
      break;
  }
};

console.log(stringify({key: 'value', key2: 'value2', key3: {key4: 'value4'}}, '|-', 2));
