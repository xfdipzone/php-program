# MySQL 消息队列数据库表结构

## 数据库

**MessageQueue** 消息队列组件数据库

可分布存储在多个数据源中，提供高可用支持

## 数据表

**topic** 消息主题表

字段 | 类型 | 说明
--|--|--
id | int(11) | 消息主题 id（自增）
name | string(128) | 主题名称
status | int(3) | 状态 1:正常 0:删除
created_at | int(11) | 创建时间
updated_at | int(11) | 最后修改时间

**partition** 消息主题分区表

字段 | 类型 | 说明
--|--|--
id | int(11) | 消息主题分区 id（自增）
topic_id | int(11) | 消息主题id (topic.id)
name | string(128) | 分区名称
status | int(3) | 状态 1:正常 0:删除
created_at | int(11) | 创建时间
updated_at | int(11) | 最后修改时间

**consumer_group** 消费者组表

字段 | 类型 | 说明
--|--|--
id | int(11) | 消费者组 id（自增）
name | string(64) | 消费者组名称
status | int(3) | 状态 1:正常 0:删除
created_at | int(11) | 创建时间
updated_at | int(11) | 最后修改时间

**consumer** 消费者表

字段 | 类型 | 说明
--|--|--
id | int(11) | 消费者 id（自增）
consumer_group_id | int(11) | 消费者组 id (consumer_group.id)
status | int(3) | 状态 1:正常 0:删除
created_at | int(11) | 创建时间
updated_at | int(11) | 最后修改时间

**consumer_offset** 消费偏移量记录表

字段 | 类型 | 说明
--|--|--
topic_id | int(11) | 消息主题 id (topic.id)
partition_id | int(11) | 消息主题分区 id (partition.id)
consumer_group_id | int(11) | 消费者组 id (consumer_group.id)
consumer_id | int(11) | 消费者 id (consumer.id)
offset | int(11) | 已消费的偏移量
status | int(3) | 状态 1:正常 0:删除
created_at | int(11) | 创建时间
updated_at | int(11) | 最后修改时间

**message** 消息表

字段 | 类型 | 说明
--|--|--
id | string(64) | 消息 id
topic_id | int(11) | 消息主题 id (topic.id)
partition_id | int(11) | 消息主题分区 id (partition.id)
data | text | 消息内容（消息体对象序列化）
created_at | int(11) | 创建时间
