package ru.mmb.terminal.activity.report.team.search;

import java.util.ArrayList;
import java.util.List;

import ru.mmb.terminal.activity.report.team.search.model.TeamListRecord;
import android.widget.Filter;

public class TeamFilter extends Filter
{
	private final TeamsAdapter owner;
	private final List<TeamListRecord> sourceItems = new ArrayList<TeamListRecord>();
	private SearchTeamActivityState currentState;
	private TeamMemberItemsComparator comparator;

	public TeamFilter(TeamsAdapter owner)
	{
		this.owner = owner;
	}

	public void initialize(List<TeamListRecord> sourceItems, SearchTeamActivityState currentState)
	{
		this.sourceItems.addAll(sourceItems);
		this.currentState = currentState;
		this.comparator = new TeamMemberItemsComparator(currentState);
	}

	@Override
	protected FilterResults performFiltering(CharSequence constraint)
	{
		List<TeamListRecord> filteredItems = getFilteredRecords();
		FilterResults result = new FilterResults();
		result.values = filteredItems;
		return result;
	}

	private List<TeamListRecord> getFilteredRecords()
	{
		List<TeamListRecord> result = new ArrayList<TeamListRecord>();
		for (TeamListRecord item : sourceItems)
		{
			if (matchesFilter(item)) result.add(item);
		}
		return result;
	}

	private boolean matchesFilter(TeamListRecord item)
	{
		if (!checkNumberFilter(item)) return false;
		if (!checkTeamFilter(item)) return false;
		if (!checkMemberFilter(item)) return false;
		return true;
	}

	private boolean checkNumberFilter(TeamListRecord item)
	{
		if (currentState.getNumberFilter() == null) return true;

		if (currentState.isFilterNumberExact())
		{
			return item.getTeamNumber() == currentState.getNumberFilterAsInt();
		}
		else
		{
			return Integer.toString(item.getTeamNumber()).contains(currentState.getNumberFilter());
		}
	}

	private boolean checkTeamFilter(TeamListRecord item)
	{
		if (currentState.getTeamFilter() == null) return true;

		return item.getTeamName().toLowerCase().contains(currentState.getTeamFilter().toLowerCase());
	}

	private boolean checkMemberFilter(TeamListRecord item)
	{
		if (currentState.getMemberFilter() == null) return true;

		return item.getMemberText().toLowerCase().contains(currentState.getMemberFilter().toLowerCase());
	}

	@Override
	protected void publishResults(CharSequence constraint, FilterResults results)
	{
		@SuppressWarnings("unchecked")
		List<TeamListRecord> filterResult = (List<TeamListRecord>) results.values;
		owner.setNotifyOnChange(false);
		owner.clear();
		if (filterResult != null)
		{
			for (TeamListRecord item : filterResult)
			{
				owner.add(item);
			}
			owner.sort(comparator);
		}
		owner.notifyDataSetChanged();
	}
}
