<?php
/*
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

/**
 * The "monitoredResourceDescriptors" collection of methods.
 * Typical usage is:
 *  <code>
 *   $loggingService = new Google_Service_Logging(...);
 *   $monitoredResourceDescriptors = $loggingService->monitoredResourceDescriptors;
 *  </code>
 */
class Google_Service_Logging_Resource_MonitoredResourceDescriptors extends Google_Service_Resource
{
  /**
   * Lists monitored resource descriptors that are used by Cloud Logging.
   * (monitoredResourceDescriptors.listMonitoredResourceDescriptors)
   *
   * @param array $optParams Optional parameters.
   *
   * @opt_param int pageSize Optional. The maximum number of results to return
   * from this request. You must check for presence of `nextPageToken` to
   * determine if additional results are available, which you can retrieve by
   * passing the `nextPageToken` value as the `pageToken` parameter in the next
   * request.
   * @opt_param string pageToken Optional. If the `pageToken` parameter is
   * supplied, then the next page of results is retrieved. The `pageToken`
   * parameter must be set to the value of the `nextPageToken` from the previous
   * response.
   * @return Google_Service_Logging_ListMonitoredResourceDescriptorsResponse
   */
  public function listMonitoredResourceDescriptors($optParams = array())
  {
    $params = array();
    $params = array_merge($params, $optParams);
    return $this->call('list', array($params), "Google_Service_Logging_ListMonitoredResourceDescriptorsResponse");
  }
}
