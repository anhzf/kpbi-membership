class Helper {
  static randStr() {
    return Math.random().toString(36).substring(2, 15)
  }
}

/**
 * @param  {Date} date
 * @param  {number} milisecondAdd
 * @return {Date}
 */
export const addDate = (date, milisecondAdd) => {
  return new Date(date.getTime() + milisecondAdd);
}

export default Helper
