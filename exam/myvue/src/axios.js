import axios from 'axios'
import qs from 'qs'

/**
 *
 * @param {string} url
 * @param {object} [data={}]
 * @returns {Promise} 
 */
export default function mypost(url, data = {}) {
    let postData = qs.stringify(data);
    return new Promise((resolve, reject) => {
        axios.post(url, postData)
            .then(response => {
                resolve(response.data);
            }, err => {
                reject(err)
            })
    })
}