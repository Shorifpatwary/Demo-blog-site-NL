const cutStringToWords = (string, wordCount) => {
  const words = string.split(' ');
  const slicedWords = words.slice(0, wordCount);
  const truncatedString = slicedWords.join(' ');
  return truncatedString;
};
export default cutStringToWords;