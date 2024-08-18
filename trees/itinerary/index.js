const dfs = (tree, targetCity, currentPath = []) => {
  const [nodeCity, rest] = tree;
  currentPath.push(nodeCity);
  if (targetCity === nodeCity) {
    return currentPath;
  }
  if (rest && rest.length > 0) {
    for (const item of rest) {
      const result = dfs(item, targetCity, currentPath);
      if (result) {
        return result;
      }
    }
  }
  currentPath.pop();
  return null;
};

const itinerary = (tree, start, finish) => {
  if ((typeof start === 'undefined') || (typeof finish === 'undefined')) {
    console.log('please set both start and finish points');
    return;
  }
  if (start === finish) {
    return start;
  }
  if ((typeof start === 'undefined') || (typeof finish === 'undefined')) {
    console.log('please set both start and finish points');
    return;
  }
  const pathToStartFromRoot = dfs(tree, start);
  const pathToFinishFromRoot = dfs(tree, finish);
  if (pathToStartFromRoot === null) {
    console.log('there is no data for start city in our system');
    return null;
  }
  if (pathToFinishFromRoot === null) {
    console.log('there is no data for finish city in our system');
    return null;
  }
  let firstPart = _.reverse(pathToStartFromRoot);
  let middle = []
  for (const item of pathToFinishFromRoot) {
    if (pathToStartFromRoot.includes(item)) {
      middle = firstPart.pop();
      continue;
    }
    break;
  }
  const secondPart = pathToFinishFromRoot.slice(_.indexOf(pathToFinishFromRoot, middle));
  return [...firstPart, ...secondPart]
}

const tree = ['Moscow', [
  ['Smolensk'],
  ['Yaroslavl'],
  ['Voronezh', [
    ['Liski'],
    ['Boguchar'],
    ['Kursk', [
      ['Belgorod', [
        ['Borisovka'],
      ]],
      ['Kurchatov'],
    ]],
  ]],
  ['Ivanovo', [
    ['Kostroma'], ['Kineshma'],
  ]],
  ['Vladimir'],
  ['Tver', [
    ['Klin'], ['Dubna'], ['Rzhev'],
  ]],
]];

console.log(itinerary(tree, 'Dubna', 'Kostroma'));
