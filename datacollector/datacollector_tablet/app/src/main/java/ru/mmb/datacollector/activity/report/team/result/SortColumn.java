package ru.mmb.datacollector.activity.report.team.result;

public enum SortColumn
{
	NUMBER,

	TEAM,

	MEMBER;

	public static SortColumn getByName(String sortColumnName)
	{
		for (SortColumn sortColumn : values())
		{
			if (sortColumn.name().equalsIgnoreCase(sortColumnName)) return sortColumn;
		}
		throw new RuntimeException("SortColumn not found for name: " + sortColumnName);
	}
}
